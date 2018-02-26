<?php

namespace Recipes\Domain\Model\Category;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;
use Recipes\Domain\Model\Translation\Translatable;

class Category extends Translatable implements AggregateRoot
{
    private $parent;
    private $children;
    private $id;

    use AggregateRootCapabilities;

    public function __construct(CategoryId $id, ?Category $parent = null, CategoriesCollection $children)
    {
        parent::__construct();
        $this->id = $id;
        $this->parent = $parent;
        $this->children = $children;
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

    protected function translationClass(): string
    {
        return CategoryTranslation::class;
    }
}