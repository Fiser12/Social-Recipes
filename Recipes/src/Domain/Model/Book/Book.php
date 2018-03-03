<?php

namespace Recipes\Domain\Model\Book;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Translation\Translatable;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;

class Book extends AggregateRoot
{
    //TODO Agregar imagen
    private $id;
    private $owner;
    private $follow;
    private $scope;
    private $recipes;

    use Translatable;

    public function __construct(
        BookId $id,
        UserId $owner,
        Scope $scope,
        UsersCollection $follow,
        RecipeCollection $recipes
    )
    {
        $this->id = $id;
        $this->owner = $owner;
        $this->follow = $follow;
        $this->scope = $scope;
        $this->recipes = $recipes;
    }

    public function id(): BookId
    {
        return $this->id;
    }

    public function owner(): UserId
    {
        return $this->owner;
    }

    public function follow(): UsersCollection
    {
        return $this->follow;
    }

    public function scope(): Scope
    {
        return $this->scope;
    }

    public function recipes(): RecipeCollection
    {
        return $this->recipes;
    }

    protected function translationClass(): string
    {
        return BookTranslation::class;
    }
}