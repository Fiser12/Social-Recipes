<?php

namespace Recipes\Domain\Model\Recipes;

interface RecipeRepository
{
    public function recipeOfId(RecipeId $recipeId) : ?Recipe;

    public function persist(Recipe $recipe) : void;

    public function remove(Recipe $recipe) : void;
}