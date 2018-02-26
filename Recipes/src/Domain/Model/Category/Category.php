<?php

namespace Recipes\Domain\Model\Category;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;
use Recipes\Domain\Model\Translation\Translatable;

class Category extends Translatable implements AggregateRoot
{
    private $parent;
    private $children;
    private $categoryId;

    use AggregateRootCapabilities;

    public function __construct(CategoryId $categoryId, ?Category $parent = null, CategoriesCollection $children)
    {
        parent::__construct();
        $this->categoryId = $categoryId;
        $this->parent = $parent;
        $this->children = $children;
    }

    public function parent(): ?Category
    {
        return $this->parent;
    }

    public function id(): CategoryId
    {
        return $this->categoryId;
    }

    public function children(): CategoriesCollection
    {
        return $this->children;
    }

    protected function translationClass(): string
    {
        return CategoryTranslation::class;
    }
}