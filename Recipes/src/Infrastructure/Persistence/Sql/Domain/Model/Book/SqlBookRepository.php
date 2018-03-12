<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Book;

use LIN3S\SharedKernel\Infrastructure\Persistence\Sql\Pdo;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookTranslation;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\User\UserId;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlBookRepository implements BookRepository
{
    private $pdo;
    private $hydrator;

    public function __construct(Pdo $pdo, SqlHydrator $hydrator)
    {
        $this->pdo = $pdo;
        $this->hydrator = $hydrator;
    }

    public function remove(BookId $bookId): void
    {
        $sql = <<<SQL
    DELETE FROM recipe_book WHERE `recipe_book`.id = :id
SQL;
        $this->pdo->execute($sql, ['id' => $bookId->id()]);
    }

    public function bookOfId(BookId $bookId): ?Book
    {
        $sql = <<<SQL
SELECT
  `recipe_book`.*,
  `recipe_book_translation`.*,
  `recipe_user_follow_book`.user_id,
  `recipe_recipe_book`.recipe_id
FROM `recipe_book`
  INNER JOIN `recipe_book_translation` ON `recipe_book`.id=`recipe_book_translation`.origin_id
  LEFT JOIN `recipe_user_follow_book` ON `recipe_book`.id=`recipe_user_follow_book`.book_id
  LEFT JOIN `recipe_recipe_book` ON `recipe_book`.id=`recipe_recipe_book`.book_id
WHERE `recipe_book`.id = :id
SQL;
        $bookRow = $this->pdo->query($sql, ['id' => $bookId->id()]);

        return !$bookRow ? null : $this->hydrator->build($bookRow);

    }

    public function persist(Book $book): void
    {
        $this->remove($book->id());
        $this->pdo->insert('recipe_book', $this->buildParameters($book));
        $this->persistAssociations($book);
        $this->persistTranslations($book);
    }

    private function buildParameters(Book $book): array
    {
        return [
            'id' => $book->id()->id(),
            'scope_scope' => $book->scope()->scope(),
            'owner_id' => $book->owner()->id(),
        ];
    }

    private function persistAssociations(Book $book): void
    {
        foreach ($book->recipes() as $recipe) {
            $this->pdo->insert('recipe_recipe_book', $this->buildRecipesParameters($recipe, $book->id()));
        }
        foreach ($book->follow() as $user) {
            $this->pdo->insert('recipe_user_follow_book', $this->buildOwnerParameters($user, $book->id()));
        }
    }

    private function buildRecipesParameters(RecipeId $recipeId, BookId $bookId): array
    {
        return [
            'book_id' => $bookId->id(),
            'recipe_id' => $recipeId->id()
        ];
    }

    private function buildOwnerParameters(UserId $userId, BookId $bookId): array
    {
        return [
            'book_id' => $bookId->id(),
            'recipe_id' => $userId->id()
        ];
    }

    private function persistTranslations(Book $book): void
    {
        foreach ($book->translations() as $translation) {
            $this->pdo->insert(
                'recipe_book_translation',
                $this->buildTranslationParameters(
                    $translation,
                    $book->id()
                )
            );
        }
    }

    private function buildTranslationParameters(BookTranslation $translation, BookId $id): array
    {
        return [
            'locale' => $translation->locale(),
            'subtitle_subtitle' => $translation->subtitle()->subtitle(),
            'title_title' => $translation->title()->title(),
            'origin_id' => $id->id()
        ];
    }
}
