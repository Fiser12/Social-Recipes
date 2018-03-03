<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Category;

use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Recipes\Recipe;

class RecipeCategory
{
    private $recipe;
    private $category;

    public function __construct(Recipe $recipe, Category $category)
    {
        $this->recipe = $recipe;
        $this->category = $category;
    }

    public function category(): Category
    {
        return $this->category;
    }

    public function recipe(): Recipe
    {
        return $this->recipe;
    }
}