<?php

namespace Recipes\Infrastructure\Symfony\Domain\Model\Recipes;

use LIN3S\SharedKernel\Infrastructure\Persistence\Sql\Pdo;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeRepository;
use Recipes\Domain\Model\Recipes\RecipeTranslation;
use Recipes\Domain\Model\Recipes\Step;
use Recipes\Domain\Model\Recipes\StepId;
use Recipes\Domain\Model\Recipes\StepTranslation;

class SQLRecipeRepository implements RecipeRepository
{
/*    private $pdo;
    private $hydrator;

    public function __construct(Pdo $pdo, Hydrator $hydrator)
    {
        $this->pdo = $pdo;
        $this->hydrator = $hydrator;
    }
*/

    public function remove(RecipeId $recipeId): void
    {
        $sql = <<<SQL
    DELETE FROM recipe_recipe WHERE `recipe_recipe`.id = :id
SQL;
        $this->pdo->execute($sql, ['id' => $recipeId->id()]);
    }

    public function recipeOfId(RecipeId $recipeId): ?Recipe
    {
        $sql = <<<SQL
SELECT
`recipe_recipe`.*,
`recipe_recipe_translation`.*,
`recipe_step`.*,
`recipe_step_translation`.*
FROM `recipe_recipe`
  INNER JOIN `recipe_recipe_translation` ON `recipe_recipe`.id=`recipe_recipe_translation`.origin_id
  LEFT JOIN `recipe_step` ON `recipe_step`.id = `recipe_recipe`.recipe_id
  LEFT JOIN `recipe_step_translation` ON `recipe_step_translation`.origin_id = `recipe_step`.id
WHERE `recipe_recipe`.id = :id
SQL;
        //TODO Rename colision fields
        $recipeRow = $this->pdo->query($sql, ['id' => $recipeId->id()]);
        //TODO Create hydrator
        return !$recipeRow ? null : $this->hydrator->build($recipeRow);

    }

    public function persist(Recipe $recipe): void
    {
        $this->remove($recipe->id());
        $this->pdo->insert('recipe_recipe', $this->buildParameters($recipe));
        $this->persistSteps($recipe);
        $this->persistTranslations($recipe);
    }

    private function buildParameters(Recipe $recipe): array
    {
        return [
            'id' => $recipe->id()->id(),
            'difficulty_difficulty' => $recipe->difficulty()->difficulty(),
            'time_seconds' => $recipe->time()->seconds(),
            'servings_servings' => $recipe->servings()->servings(),
            'scope_scope' => $recipe->scope()->scope(),
            'hashtags' => $recipe->hashtags()->jsonSerialize(),
            'tools' => $recipe->tools()->jsonSerialize(),
            'ingredients' => $recipe->ingredients()->jsonSerialize(),
            'owner_id' => $recipe->owner()->id()
        ];
    }

    private function persistSteps(Recipe $recipe): void
    {
        foreach ($recipe->steps() as $step) {
            $this->pdo->insert('recipe_step', $this->buildStepParameters($step, $recipe->id()));
            $this->persistStepTranslations($step);
        }
    }

    private function buildStepParameters(Step $step, RecipeId $id): array
    {
        return [
            'ingredients' => $step->ingredients(),
            'tools' => $step->tools(),
            'recipe_id' => $id->id()
        ];
    }

    private function persistStepTranslations(Step $step): void
    {
        foreach ($step->translations() as $translation) {
            $this->pdo->insert(
                'recipe_recipe_translation',
                $this->buildStepTranslationParameters(
                    $translation,
                    $step->id()
                )
            );
        }
    }

    private function buildStepTranslationParameters(StepTranslation $translation, StepId $id): array
    {
        return [
            'locale' => $translation->locale(),
            'description_description' => $translation->description()->description(),
            'origin_id' => $id->id()
        ];
    }

    private function persistTranslations(Recipe $recipe): void
    {
        foreach ($recipe->translations() as $translation) {
            $this->pdo->insert(
                'recipe_recipe_translation',
                $this->buildTranslationParameters(
                    $translation,
                    $recipe->id()
                )
            );
        }
    }

    private function buildTranslationParameters(RecipeTranslation $translation, RecipeId $id): array
    {
        return [
            'locale' => $translation->locale(),
            'description_description' => $translation->description()->description(),
            'subtitle_subtitle' => $translation->subtitle()->subtitle(),
            'title_title' => $translation->title()->title(),
            'origin_id' => $id->id()
        ];
    }
}
