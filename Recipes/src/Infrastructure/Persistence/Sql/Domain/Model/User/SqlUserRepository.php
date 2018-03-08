<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\User;

use LIN3S\SharedKernel\Infrastructure\Persistence\Sql\Pdo;
use LIN3S\SharedKernel\Domain\Model\Identity\Id;
use Recipes\Domain\Model\User\User;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlUserRepository implements UserRepository
{
    private $pdo;
    private $hydrator;

    public function __construct(Pdo $pdo, SqlHydrator $hydrator)
    {
        $this->pdo = $pdo;
        $this->hydrator = $hydrator;
    }

    public function remove(UserId $userId): void
    {
        $sql = <<<SQL
    DELETE FROM recipe_user WHERE `recipe_user`.id = :id
SQL;
        $this->pdo->execute($sql, ['id' => $userId->id()]);
    }

    public function userOfId(UserId $userId): ?User
    {
        $sql = <<<SQL
SELECT
  recipe_user.id,
  recipe_user.email_email,
  recipe_book.id AS book_create_id,
  recipe_recipe.id AS recipe_create_id,
  recipe_user_follow_book.book_id AS book_follow_id

FROM `recipe_user`
  LEFT JOIN `recipe_recipe` ON `recipe_recipe`.owner_id = `recipe_user`.id
  LEFT JOIN `recipe_book` ON `recipe_recipe`.owner_id = `recipe_user`.id
  LEFT JOIN `recipe_user_follow_book` ON `recipe_user_follow_book`.user_id = `recipe_user`.id

WHERE `recipe_user`.id = :id
SQL;
        $recipeRow = $this->pdo->query($sql, ['id' => $userId->id()]);

        return !$recipeRow ? null : $this->hydrator->build($recipeRow);

    }

    public function persist(User $user): void
    {
        $this->remove($user->id());
        $this->pdo->insert('recipe_user', $this->buildParameters($user));
        $this->persistAssociations($user);
    }

    private function buildParameters(User $user): array
    {
        return [
            'id' => $user->id()->id(),
            'email_email' => $user->email()->email(),
            'email_localPart' => $user->email()->localPart(),
            'email_domain' => $user->email()->domain()
        ];
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
