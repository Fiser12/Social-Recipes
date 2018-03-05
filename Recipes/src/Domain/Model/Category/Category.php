<?php

namespace Recipes\Domain\Model\Category;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Translation\Translatable;

class Category extends AggregateRoot
{
    protected $id;
    protected $recipes;

    use Translatable{
        Translatable::__construct as private __translatableConstruct;
    }

    public function __construct(
        CategoryId $id,
        RecipeCollection $recipes
    )
    {
        $this->__translatableConstruct();
        $this->id = $id;
        $this->recipes = $recipes;
    }


    public function id(): CategoryId
    {
        return $this->id;
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