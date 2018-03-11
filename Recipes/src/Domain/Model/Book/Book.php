<?php

namespace Recipes\Domain\Model\Book;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\DateTime\DateTime;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Translation\Translatable;
use Recipes\Domain\Model\Translation\TranslationCollection;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;

class Book extends AggregateRoot
{
    //TODO Agregar imagen
    protected $id;
    protected $owner;
    protected $follow;
    protected $scope;
    protected $recipes;
    protected $creationDate;
    protected $editDate;

    use Translatable{
        Translatable::__construct as private __translatableConstruct;
    }

    public function __construct(
        BookId $id,
        UserId $owner,
        Scope $scope,
        UsersCollection $follow,
        RecipeCollection $recipes
    )
    {
        $this->__translatableConstruct();
        $this->id = $id;
        $this->owner = $owner;
        $this->follow = $follow;
        $this->scope = $scope;
        $this->recipes = $recipes;
        $this->creationDate = new DateTime();
        $this->editDate = new DateTime();
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
        return new UsersCollection($this->follow->getValues());
    }

    public function scope(): Scope
    {
        return $this->scope;
    }

    public function recipes(): RecipeCollection
    {
        return new RecipeCollection($this->recipes->getValues());
    }

    protected function translationClass(): string
    {
        return BookTranslation::class;
    }

    public function edit(
        UserId $owner,
        Scope $scope,
        UsersCollection $follow,
        RecipeCollection $recipes,
        TranslationCollection $translations
    ) : void {
        $this->owner = $owner;
        $this->follow = $follow;
        $this->scope = $scope;
        $this->recipes = $recipes;
        $this->translations = $translations;
        $this->editDate = new DateTime();
    }

    public function addRecipeToBook(RecipeId $recipeId) : void
    {
        $this->recipes->add($recipeId);
    }

    public function removeRecipeFromBook(RecipeId $recipeId) : void
    {
        $this->recipes->remove($recipeId);
    }

    public function creationDate(): DateTime
    {
        return $this->creationDate;
    }

    public function editDate(): DateTime
    {
        return $this->editDate;
    }

}