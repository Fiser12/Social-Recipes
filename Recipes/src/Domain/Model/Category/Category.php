<?php

namespace Recipes\Domain\Model\Category;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Translation\Translatable;

class Category extends AggregateRoot
{
    private $parent;
    private $children;
    private $id;
    private $recipes;

    use Translatable;

    public function __construct(
        CategoryId $id,
        RecipeCollection $recipes,
        ?CategoryId $parent = null,
        CategoriesCollection $children
    )
    {
        $this->id = $id;
        $this->parent = $parent;
        $this->children = $children;
        $this->recipes = $recipes;
    }

    public function parent(): CategoryId
    {
        return $this->parent;
    }

    public function id(): CategoryId
    {
        return $this->id;
    }

    public function children(): CategoriesCollection
    {
        return $this->children;
    }

    public function recipes(): RecipeCollection
    {
        return $this->recipes;
    }

    protected function translationClass(): string
    {
        return CategoryTranslation::class;
    }
}