<?php

namespace Recipes\Domain\Model\Category;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Translation\Translatable;

class Category extends Translatable implements AggregateRoot
{
    private $parent;
    private $children;
    private $id;
    private $recipes;

    use AggregateRootCapabilities;

    public function __construct(
        CategoryId $id,
        RecipeCollection $recipes,
        ?Category $parent = null,
        CategoriesCollection $children
    )
    {
        parent::__construct();
        $this->id = $id;
        $this->parent = $parent;
        $this->children = $children;
        $this->recipes = $recipes;
    }

    public function parent(): ?Category
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