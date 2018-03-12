<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Category;

use LIN3S\SharedKernel\Infrastructure\Persistence\Sql\Pdo;
use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Category\CategoryId;
use Recipes\Domain\Model\Category\CategoryRepository;
use Recipes\Domain\Model\Category\CategoryTranslation;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlCategoryRepository implements CategoryRepository
{
    private $pdo;
    private $hydrator;

    public function __construct(Pdo $pdo, SqlHydrator $hydrator)
    {
        $this->pdo = $pdo;
        $this->hydrator = $hydrator;
    }

    public function remove(CategoryId $categoryId): void
    {
        $sql = <<<SQL
    DELETE FROM recipe_category WHERE `recipe_category`.id = :id
SQL;
        $this->pdo->execute($sql, ['id' => $categoryId->id()]);
    }

    public function categoryOfId(CategoryId $categoryId): ?Category
    {
        $sql = <<<SQL
SELECT
`recipe_category`.*,
`recipe_category_translation`.*,
`recipe_recipe_category`.recipe_id

FROM `recipe_category`
  INNER JOIN `recipe_category_translation` ON `recipe_category`.id=`recipe_category_translation`.origin_id
  LEFT JOIN `recipe_recipe_category` ON `recipe_category`.id=`recipe_recipe_category`.category_id
WHERE `recipe_category`.id = :id
SQL;
        $categoryRow = $this->pdo->query($sql, ['id' => $categoryId->id()]);
        return !$categoryRow ? null : $this->hydrator->build($categoryRow);
    }

    public function persist(Category $category): void
    {
        $this->remove($category->id());
        $this->pdo->insert('recipe_category', $this->buildParameters($category));
        $this->persistTranslations($category);
    }

    private function buildParameters(Category $category): array
    {
        return [
            'id' => $category->id()->id(),
        ];
    }

    private function persistTranslations(Category $category): void
    {
        foreach ($category->translations() as $translation) {
            $this->pdo->insert(
                'recipe_category_translation',
                $this->buildTranslationParameters(
                    $translation,
                    $category->id()
                )
            );
        }
    }

    private function buildTranslationParameters(CategoryTranslation $translation, CategoryId $id): array
    {
        return [
            'locale' => $translation->locale(),
            'name_name' => $translation->name()->name(),
            'origin_id' => $id->id()
        ];
    }
}
