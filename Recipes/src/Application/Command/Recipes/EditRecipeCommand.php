<?php

namespace Recipes\Application\Command\Recipes;

class EditRecipeCommand
{
    private $translations;
    private $id;
    private $steps;
    private $hashtag;
    private $ingredients;
    private $tools;
    private $servings;
    private $timeSeconds;
    private $difficulty;
    private $scope;
    private $owner_id;
    private $books;
    private $categories;

    public function __construct(
        array $steps,
        array $hashtag,
        array $ingredients,
        array $tools,
        array $categories,
        int $servings,
        int $timeSeconds,
        string $difficulty,
        string $scope,
        string $owner_id,
        array $books,
        array $translations,
        string $id
    )
    {
        $this->translations = $translations;
        $this->id = $id;
        $this->steps = $steps;
        $this->hashtag = $hashtag;
        $this->ingredients = $ingredients;
        $this->tools = $tools;
        $this->servings = $servings;
        $this->timeSeconds = $timeSeconds;
        $this->difficulty = $difficulty;
        $this->scope = $scope;
        $this->owner_id = $owner_id;
        $this->books = $books;
        $this->categories = $categories;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function translations(): array
    {
        return $this->translations;
    }

    public function steps(): array
    {
        return $this->steps;
    }

    public function hashtag(): array
    {
        return $this->hashtag;
    }

    public function ingredients(): array
    {
        return $this->ingredients;
    }

    public function tools(): array
    {
        return $this->tools;
    }

    public function servings(): int
    {
        return $this->servings;
    }

    public function timeSeconds(): int
    {
        return $this->timeSeconds;
    }

    public function difficulty(): string
    {
        return $this->difficulty;
    }

    public function scope(): string
    {
        return $this->scope;
    }

    public function ownerId(): string
    {
        return $this->owner_id;
    }

    public function books(): array
    {
        return $this->books;
    }

    public function categories(): array
    {
        return $this->categories;
    }
}