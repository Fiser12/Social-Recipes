<?php

namespace Recipes\Application\Command\Recipes;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use LIN3S\SharedKernel\Exception\Exception;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Category\CategoryId;
use Recipes\Domain\Model\Description;
use Recipes\Domain\Model\Difficulty;
use Recipes\Domain\Model\Recipes\HashtagCollection;
use Recipes\Domain\Model\Recipes\IngredientsCollection;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeRepository;
use Recipes\Domain\Model\Recipes\RecipeTranslation;
use Recipes\Domain\Model\Recipes\Servings;
use Recipes\Domain\Model\Recipes\Step;
use Recipes\Domain\Model\Recipes\StepId;
use Recipes\Domain\Model\Recipes\StepsCollection;
use Recipes\Domain\Model\Recipes\StepTranslation;
use Recipes\Domain\Model\Recipes\ToolsCollection;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Subtitle;
use Recipes\Domain\Model\Time;
use Recipes\Domain\Model\Title;
use Recipes\Domain\Model\Translation\TranslationCollection;
use Recipes\Domain\Model\User\UserId;

class EditRecipe
{
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EditRecipeCommand $command)
    {
        $recipe = $this->repository->recipeOfId(RecipeId::generate($command->id()));

        if(!$recipe->owner()->equals(UserId::generate($command->ownerId()))) {
            throw new Exception('The recipe is of another user');
        }

        $recipe->edit(
            $this->steps($command->steps(), RecipeId::generate($command->id())),
            HashtagCollection::fromJson($command->hashtag()),
            IngredientsCollection::fromJson($command->ingredients()),
            ToolsCollection::fromJson($command->tools()),
            $this->categories($command->categories()),
            new Servings($command->servings()),
            new Time($command->timeSeconds()),
            new Difficulty($command->difficulty()),
            new Scope($command->scope()),
            UserId::generate($command->ownerId()),
            $this->books($command->books()),
            $this->translations($command->translations())
        );

        $this->repository->persist($recipe);
    }

    private function steps(array $steps, RecipeId $recipeId) : StepsCollection
    {
        $stepsCollection = new StepsCollection();

        foreach($steps as $stepArray) {
            $step = new Step(
                StepId::generate($stepArray['id']),
                IngredientsCollection::fromJson($stepArray['ingredients']),
                ToolsCollection::fromJson($stepArray['tools']),
                $recipeId
            );

            $this->stepTranslations($stepArray['translations'], $step);

            $stepsCollection->add($step);
        }

        return $stepsCollection;
    }

    private function stepTranslations(array $translationsArray, $step): void
    {
        foreach ($translationsArray as $locale => $translationArray) {
            $translation = new StepTranslation(
                new Locale($locale),
                new Description($translationArray['description']
                )
            );

            $step->addTranslation($translation);
        }
    }

    private function categories(array $categories) : CategoriesCollection
    {
        $collection = new CategoriesCollection();

        foreach($categories as $id) {
            $collection->add(CategoryId::generate($id));
        }
    }

    private function books(array $books) : BooksCollection
    {
        $collection = new BooksCollection();

        foreach($books as $id) {
            $collection->add(BookId::generate($id));
        }
    }

    private function translations(array $translationsArray): TranslationCollection
    {
        $translations = new TranslationCollection();
        foreach ($translationsArray as $locale => $translationArray) {
            $translation = new RecipeTranslation(
                new Locale($locale),
                new Title($translationArray['title']),
                new Subtitle($translationArray['subtitle']),
                new Description($translationArray['description'])
            );
            $translations->add($translation);
        }
        return $translations;
    }
}