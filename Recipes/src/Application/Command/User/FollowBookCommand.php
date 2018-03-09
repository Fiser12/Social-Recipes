<?php

namespace Recipes\Application\Command\User;

class FollowBookCommand
{
    private $bookId;
    private $userId;

    public function __construct(
        string $bookId,
        string $userId
    )
    {
        $this->userId = $userId;
        $this->bookId = $bookId;
    }

    public function userId(): string
    {
        return $this->userId;
    }

    public function bookId(): string
    {
        return $this->bookId;
    }
}