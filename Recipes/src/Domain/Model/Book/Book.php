<?php

namespace Recipes\Domain\Model\Book;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Translation\Translatable;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;

class Book extends Translatable implements AggregateRoot
{
    //TODO Agregar imagen
    private $id;
    private $owner;
    private $follow;
    private $scope;
    private $create;
    private $recipes;

    use AggregateRootCapabilities;

    public function __construct(
        BookId $id,
        UserId $owner,
        Scope $scope,
        UsersCollection $follow,
        UsersCollection $create,
        RecipeCollection $recipes
    )
    {
        parent::__construct();
        $this->id = $id;
        $this->owner = $owner;
        $this->follow = $follow;
        $this->scope = $scope;
        $this->create = $create;
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

    public function create(): UsersCollection
    {
        return $this->create;
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