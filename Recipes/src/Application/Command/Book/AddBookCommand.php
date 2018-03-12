<?php

namespace Recipes\Application\Command\Book;

class AddBookCommand
{
    private $userId;
    private $scope;
    private $follow;
    private $recipeIds;
    private $translations;
    private $id;

    public function __construct(
        string $userId,
        string $scope,
        array $follow,
        array $recipeIds,
        array $translations,
        string $id = null
    )
    {
        $this->userId = $userId;
        $this->scope = $scope;
        $this->follow = $follow;
        $this->recipeIds = $recipeIds;
        $this->translations = $translations;
        $this->id = $id;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function scope(): string
    {
        return $this->scope;
    }

    public function follow(): array
    {
        return $this->follow;
    }

    public function recipeIds(): array
    {
        return $this->recipeIds;
    }

    public function translations(): array
    {
        return $this->translations;
    }

    public function id(): ?string
    {
        return $this->id;
    }
}