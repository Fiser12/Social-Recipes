<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\User;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use LIN3S\SharedKernel\Exception\Exception;
use LIN3S\SharedKernel\Infrastructure\Persistence\Sql\Pdo;
use LIN3S\SharedKernel\Domain\Model\Identity\Id;
use Recipes\Domain\Model\User\User;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SqlUserRepository implements UserRepository
{
    const USER_API = 'http://nginx/session/user/';

    private $pdo;
    private $hydrator;
    private $client;
    private $container;

    public function __construct(Pdo $pdo, SqlHydrator $hydrator, Client $client, ContainerInterface $container)
    {
        $this->pdo = $pdo;
        $this->hydrator = $hydrator;
        $this->client = $client;
        $this->container = $container;
    }

    public function remove(UserId $userId): void
    {
        $sql = <<<SQL
    DELETE FROM recipe_user_follow_book WHERE `recipe_user_follow_book`.user_id = :id
SQL;
        $this->pdo->execute($sql, ['id' => $userId->id()]);
    }

    public function userOfId(UserId $userId): ?User
    {
        $sql = <<<SQL
SELECT
  recipe_user_follow_book.user_id,
  recipe_book.id AS book_create_id,
  recipe_recipe.id AS recipe_create_id,
  recipe_user_follow_book.book_id AS book_follow_id

FROM `recipe_user_follow_book`
  LEFT JOIN `recipe_recipe` ON `recipe_recipe`.owner_id = `recipe_user_follow_book`.user_id
  LEFT JOIN `recipe_book` ON `recipe_recipe`.owner_id = `recipe_user_follow_book`.user_id

WHERE `recipe_user_follow_book`.user_id = :id
SQL;
        $userRow = $this->pdo->query($sql, ['id' => $userId->id()]);
        $userRow = $this->addAddtionalFields($userId, $userRow);

        return !$userRow ? null : $this->hydrator->build($userRow);
    }

    private function userInfo(UserId $userId): array
    {
        try {
            $response = $this->client->request(
                'GET',
                self::USER_API,
                [
                    'headers' => $this->container->getParameter('headers'),
                    'query' => ['id' => $userId->id()]
                ]
            );
        } catch (ClientException $clientException) {
            if (404 === $clientException->getCode()) {
                throw new Exception('User does not exist in ' . $clientException->getMessage());
            }
            throw $clientException;
        }
        return json_decode($response->getBody()->getContents(), true)['user'];
    }

    private function addAddtionalFields(UserId $userId, array $results): array
    {
        $userAdditionalData = $this->userInfo($userId);

        if (empty($results)) {
            return [
                [
                    'user_id' => $userAdditionalData['id'],
                    'email' => $userAdditionalData['email'],
                    'friends' => $userAdditionalData['friends']
                ]
            ];
        }

        $processedData = [];
        foreach ($results as $result) {
            $result['email'] = $userAdditionalData['email'];
            $result['friends'] = $userAdditionalData['friends'];
            $processedData[] = $result;
        }

        return $processedData;
    }

    public function persist(User $user): void
    {
        $this->remove($user->id());
        $this->persistAssociations($user);
    }

    private function persistAssociations(User $user): void
    {
        foreach ($user->followBooks() as $followBook) {
            $this->pdo->insert('recipe_user_follow_book', [
                    'user_id' => $user->id()->id(),
                    'book_id' => $followBook->id()->id()
                ]
            );
        }

        foreach ($user->createRecipes() as $recipeId) {
            $this->updateOwnerField($user, $recipeId, 'recipe_recipe');
        }

        foreach ($user->createBooks() as $bookId) {
            $this->updateOwnerField($user, $bookId, 'recipe_book');
        }
    }

    private function updateOwnerField(User $user, Id $id, string $table): void
    {
        $sql = <<<SQL
UPDATE $table SET owner_id = :owner_id WHERE id = :id
SQL;

        $this->pdo->execute($sql, [
            'owner_id' => $user->id()->id(),
            'id' => $id->id()
        ]);
    }
}
