<?php

namespace Recipes\Application\Query\Book;

class GetBooksByFollowQuery
{
    private $page;
    private $pageSize;
    private $userId;
    private $followId;

    public function __construct(
        ?string $userId,
        string $followId,
        int $page = 1,
        int $pageSize = -1
    )
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->userId = $userId;
        $this->followId = $followId;
    }

    public function page(): int
    {
        return $this->page;
    }

    public function pageSize(): int
    {
        return $this->pageSize;
    }

    public function userId(): ?string
    {
        return $this->userId;
    }

    public function followId(): string
    {
        return $this->followId;
    }

}