<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\DateTime\DateTime;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Difficulty;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Time;
use Recipes\Domain\Model\Translation\Translatable;
use Recipes\Domain\Model\Translation\TranslationCollection;
use Recipes\Domain\Model\User\UserId;

class Recipe extends AggregateRoot
{
    protected $id;
    protected $ingredients;
    protected $tools;
    protected $steps;
    protected $servings;
    protected $time;
    protected $difficulty;
    protected $owner;
    protected $books;
    protected $categories;
    protected $hashtags;
    protected $scope;
    protected $creationDate;
    protected $editDate;

    use Translatable{
        Translatable::__construct as protected __translatableConstruct;
    }

    public function __construct(
        RecipeId $id,
        StepsCollection $steps,
        HashtagCollection $hashtags,
        IngredientsCollection $ingredients,
        ToolsCollection $tools,
        CategoriesCollection $categories,
        Servings $servings,
        Time $time,
        Difficulty $difficulty,
        Scope $scope,
        UserId $owner,
        BooksCollection $books
    )
    {
        $this->__translatableConstruct();
        $this->id = $id;
        $this->ingredients = $ingredients;
        $this->tools = $tools;
        $this->steps = $steps;
        $this->servings = $servings;
        $this->time = $time;
        $this->difficulty = $difficulty;
        $this->owner = $owner;
        $this->books = $books;
        $this->categories = $categories;
        $this->hashtags = $hashtags;
        $this->scope = $scope;
        $this->creationDate = new DateTime();
        $this->editDate = new DateTime();
    }

    public function id(): RecipeId
    {
        return $this->id;
    }

    public function ingredients(): IngredientsCollection
    {
        return new IngredientsCollection($this->ingredients->getValues());
    }

    public function tools(): ToolsCollection
    {
        return new ToolsCollection($this->tools->getValues());
    }

    public function steps(): StepsCollection
    {
        return new StepsCollection($this->steps->getValues());
    }

    public function servings(): Servings
    {
        return $this->servings;
    }

    public function time(): Time
    {
        return $this->time;
    }

    public function difficulty(): Difficulty
    {
        return $this->difficulty;
    }

    public function owner(): UserId
    {
        return $this->owner;
    }

    public function books(): BooksCollection
    {
        return new BooksCollection($this->books->getValues());
    }

    public function categories(): CategoriesCollection
    {
        return new CategoriesCollection($this->categories->getValues());
    }

    public function hashtags(): HashtagCollection
    {
        return new HashtagCollection($this->hashtags->getValues());
    }

    public function scope(): Scope
    {
        return $this->scope;
    }

    public function creationDate(): DateTime
    {
        return $this->creationDate;
    }

    public function editDate(): DateTime
    {
        return $this->editDate;
    }

    protected function translationClass(): string
    {
        return RecipeTranslation::class;
    }

    public function edit(
        StepsCollection $steps,
        HashtagCollection $hashtags,
        IngredientsCollection $ingredients,
        ToolsCollection $tools,
        CategoriesCollection $categories,
        Servings $servings,
        Time $time,
        Difficulty $difficulty,
        Scope $scope,
        UserId $owner,
        BooksCollection $books,
        TranslationCollection $translations
    ) {
        $this->ingredients = $ingredients;
        $this->tools = $tools;
        $this->steps = $steps;
        $this->servings = $servings;
        $this->time = $time;
        $this->difficulty = $difficulty;
        $this->owner = $owner;
        $this->books = $books;
        $this->categories = $categories;
        $this->hashtags = $hashtags;
        $this->scope = $scope;
        $this->translations = $translations;
        $this->editDate = new DateTime();
    }
}