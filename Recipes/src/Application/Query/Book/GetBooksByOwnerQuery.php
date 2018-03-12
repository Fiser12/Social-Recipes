<?php

namespace Recipes\Application\Query\Book;

class GetBooksByOwnerQuery
{
    private $page;
    private $pageSize;
    private $userId;
    private $ownerId;

    public function __construct(
        string $ownerId,
        ?string $userId,
        int $page = 1,
        int $pageSize = -1
    )
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->userId = $userId;
        $this->ownerId = $ownerId;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function pageSize(): int
    {
        return $this->pageSize;
    }

    public function ownerId(): string
    {
        return $this->ownerId;
    }

    public function userId(): ?string
    {
        return $this->userId;
    }
}