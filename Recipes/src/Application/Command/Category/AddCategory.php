<?php

namespace Recipes\Application\Command\Category;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Category\CategoryId;
use Recipes\Domain\Model\Category\CategoryRepository;
use Recipes\Domain\Model\Category\CategoryTranslation;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Recipes\RecipeId;

class AddCategory
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddCategoryCommand $command)
    {
        $category = new Category(
            CategoryId::generate($command->id()),
            $this->recipes($command->recipeIds())
        );

        $this->translations($command->translations(), $category);

        $this->repository->persist($category);
    }

    private function recipes(array $recipeIds): RecipeCollection
    {
        $collection = new RecipeCollection();

        foreach($recipeIds as $id) {
            $collection->add(RecipeId::generate($id));
        }
        return $collection;
    }

    private function translations(array $translationsArray, Category $category): void
    {
        foreach ($translationsArray as $locale => $translationArray) {
            $translation = new CategoryTranslation(
                new Locale($locale),
                new Name($translationArray['name'])
            );
            $category->addTranslation($translation);
        }
    }
}