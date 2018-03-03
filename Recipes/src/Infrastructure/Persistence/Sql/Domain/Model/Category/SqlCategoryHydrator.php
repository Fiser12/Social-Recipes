<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Category;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Category\CategoryId;
use Recipes\Domain\Model\Category\CategoryTranslation;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Translation\TranslationCollection;
use Recipes\Infrastructure\Persistence\Hydrator;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlCategoryHydrator implements SqlHydrator
{
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function build(array $rows): Category
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
                'id' => $data['id'] ?? CategoryId::generate($row['id']),
                'parent' => $data['parent']
                    ?? ($row['parent_id'] === null
                        ? null
                        : CategoryId::generate($row['parent_id'])),
                'locale' => $data['locale'] ?? new Locale($row['locale']),
                'translations' => $data['translations'] ?? new TranslationCollection(),
                'children' => $data['children'] ?? new CategoriesCollection(),
                'recipes' => $data['recipes'] ?? new RecipeCollection()
            ];

            $translation = new CategoryTranslation(
                new Locale($row['locale']),
                new Name($row['name_name'])
            );

            $data['translations']->contains($translation) ?: $data['translations']->add($translation);

            if (isset($row['children_id'])) {
                $childrenId = CategoryId::generate($row['children_id']);
                $data['children']->contains($childrenId) ?: $data['children']->add($childrenId);
            }

            if (isset($row['recipe_id'])) {
                $recipeId = RecipeId::generate($row['recipe_id']);
                $data['recipes']->contains($recipeId) ?: $data['recipes']->add($recipeId);
            }

        }

        return $data;

    }

}