<?php

namespace Recipes\Application\Query\Recipes;

class GetRecipesByBooksQuery
{
    private $bookIds;
    private $page;
    private $pageSize;
    private $userId;

    public function __construct(
        ?string $userId,
        array $bookIds,
        int $page = 1,
        int $pageSize = -1
    )
    {
        $this->bookIds = $bookIds;
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->userId = $userId;
    }

    public function bookIds(): array
    {
        return $this->bookIds;
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