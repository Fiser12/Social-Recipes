<?php

namespace Recipes\Application\Command\Book;

class RemoveBookCommand
{
    private $id;
    private $userId;

    public function __construct(string $id, string $userId)
    {
        $this->id = $id;
        $this->userId = $userId;
    }

    public function id(): string
    {
        return $this->id;
    }

    public function userId(): string
    {
        return $this->userId;
    }

}