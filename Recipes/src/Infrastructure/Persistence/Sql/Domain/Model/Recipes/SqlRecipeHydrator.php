<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\DateTime\DateTime;
use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Description;
use Recipes\Domain\Model\Difficulty;
use Recipes\Domain\Model\Recipes\HashtagCollection;
use Recipes\Domain\Model\Recipes\IngredientsCollection;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\Recipes\RecipeId;
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
use Recipes\Infrastructure\Persistence\Hydrator;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlRecipeHydrator implements SqlHydrator
{
    private $hydratorRecipe;

    public function __construct(Hydrator $hydratorRecipe)
    {
        $this->hydratorRecipe = $hydratorRecipe;
    }

    public function build(array $rows): Recipe
    {
        return $this->hydratorRecipe->hydrate(
            $this->organizeRows($rows)
        );
    }

    private function organizeRows(array $rows): array
    {
        $data = [];

        foreach ($rows as $row) {

            $data = [
                'id' => $data['id'] ?? RecipeId::generate($row['id']),
                'owner' => $data['owner'] ?? UserId::generate($row['owner_id']),
                'difficulty' => $data['difficulty'] ?? new Difficulty($row['difficulty_difficulty']),
                'servings' => $data['servings'] ?? new Servings($row['servings_servings']),
                'scope' => $data['scope'] ?? new Scope($row['scope_scope']),
                'time' => $data['time'] ?? new Time($row['time_seconds']),
                'translations' => $data['translations'] ?? new TranslationCollection(),
                'steps' => $data['steps'] ?? new StepsCollection(),
                'creationDate' => $data['creationDate'] ?? new DateTime(),
                'editDate' => $data['editDate'] ?? new DateTime(),
                'ingredients' => $data['ingredients']
                    ?? IngredientsCollection::fromJson(json_decode($row['ingredients'], true)),
                'tools' => $data['tools']
                    ?? ToolsCollection::fromJson(json_decode($row['tools'], true)),
                'hashtags' => $data['hashtags']
                    ?? HashtagCollection::fromJson(json_decode($row['hashtags'], true))
            ];

            $translation = new RecipeTranslation(
                new Locale($row['locale']),
                new Title($row['title_title']),
                new Subtitle($row['subtitle_subtitle']),
                new Description($row['description_description'])
            );

            $data['translations']->contains($translation) ?: $data['translations']->add($translation);

            $step = new Step(
                StepId::generate($row['step_id']),
                IngredientsCollection::fromJson(json_decode($row['ingredients_step'], true)),
                ToolsCollection::fromJson(json_decode($row['tools_step'], true)),
                RecipeId::generate($row['id'])
            );

            $data['steps']->contains($step) ?: $data['step']->add($step);

            $stepTranslation = new StepTranslation(
                new Locale($row['step_translation_locale']),
                new Description($row['step_translation_description'])
            );

            $step->translations()->contains($stepTranslation) ?: $step->addTranslation($translation);

        }
        return $data;
    }
}