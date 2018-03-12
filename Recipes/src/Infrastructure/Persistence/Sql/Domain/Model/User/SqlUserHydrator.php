<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\User;

use LIN3S\SharedKernel\Domain\Model\Email\Email;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\User\User;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;
use Recipes\Infrastructure\Persistence\Hydrator;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlUserHydrator implements SqlHydrator
{
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function build(array $rows): User
    {
        return $this->hydrator->hydrate(
            $this->organizeRows($rows)
        );
    }

    private function organizeRows(array $rows): array
    {
        $data = [];

        foreach ($rows as $row) {

            $data = [
                'id' => $data['id'] ?? UserId::generate($row['user_id']),
                'email' => $data['email'] ?? new Email($row['email']),
                'createBooks' => $data['createBooks'] ?? new BooksCollection(),
                'followBooks' => $data['followBooks'] ?? new BooksCollection(),
                'createRecipes' => $data['createRecipes'] ?? new RecipeCollection(),
                'friends' => $data['friends'] ?? new UsersCollection()

            ];

            if (isset($row['book_create_id'])) {
                $bookId = BookId::generate($row['book_create_id']);
                $data['createBooks']->contains($bookId) ?: $data['createBooks']->add($bookId);
            }

            if (isset($row['book_follow_id'])) {
                $bookId = BookId::generate($row['book_follow_id']);
                $data['followBooks']->contains($bookId) ?: $data['followBooks']->add($bookId);
            }
            if (isset($row['recipe_create_id'])) {
                $recipeId = RecipeId::generate($row['recipe_create_id']);
                $data['createRecipes']->contains($recipeId) ?: $data['createRecipes']->add($recipeId);
            }

            foreach ($row['friends'] as $friend) {
                $user = UserId::generate($friend);
                $data['friends']->contains($user) ?: $data['friends']->add($user);
            }
        }

        return $data;
    }
}