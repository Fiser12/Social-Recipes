<?php

namespace Recipes\Application\Query\Book;

class GetBooksByFollowQuery
{
    private $page;
    private $pageSize;
    private $userId;

    public function __construct(
        ?string $userId,
        int $page = 1,
        int $pageSize = -1
    )
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->userId = $userId;
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

}