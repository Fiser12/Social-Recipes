<?php

namespace Recipes\Application\Command\Book;

class RemoveRecipeToBookCommand
{
    private $bookId;
    private $recipeId;
    private $userId;

    public function __construct(
        string $bookId,
        string $recipeId,
        string $userId
    )
    {
        $this->userId = $userId;
        $this->bookId = $bookId;
        $this->recipeId = $recipeId;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function recipeId(): string
    {
        return $this->recipeId;
    }

    public function bookId(): string
    {
        return $this->bookId;
    }
}