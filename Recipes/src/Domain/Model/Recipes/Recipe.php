<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Difficulty;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Time;
use Recipes\Domain\Model\Translation\Translatable;
use Recipes\Domain\Model\User\CommentsCollection;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;

class Recipe extends Translatable implements AggregateRoot
{
    private $id;
    private $ingredients;
    private $tools;
    private $steps;
    private $servings;
    private $time;
    private $difficulty;
    private $owner;
    private $books;
    private $categories;
    private $hashtags;
    private $comments;
    private $scope;

    use AggregateRootCapabilities;

    //TODO agregar imagen
    public function __construct(
        RecipeId $id,
        IngredientsCollection $ingredients,
        ToolsCollection $tools,
        StepsCollection $steps,
        HashtagCollection $hashtags,
        CommentsCollection $comments,
        CategoriesCollection $categories,
        Servings $servings,
        Time $time,
        Difficulty $difficulty,
        Scope $scope,
        UserId $owner,
        BooksCollection $books
    )
    {
        parent::__construct();
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
        $this->comments = $comments;
        $this->scope = $scope;
    }

    public function id(): RecipeId
    {
        return $this->id;
    }

    public function ingredients(): IngredientsCollection
    {
        return $this->ingredients;
    }

    public function tools(): ToolsCollection
    {
        return $this->tools;
    }

    public function steps(): StepsCollection
    {
        return $this->steps;
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
        return $this->books;
    }

    public function categories(): CategoriesCollection
    {
        return $this->categories;
    }

    public function hashtags(): HashtagCollection
    {
        return $this->hashtags;
    }

    public function comments(): CommentsCollection
    {
        return $this->comments;
    }

    public function scope(): Scope
    {
        return $this->scope;
    }

    protected function translationClass(): string
    {
        return RecipeTranslation::class;
    }
}