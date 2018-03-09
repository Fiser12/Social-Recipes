<?php

namespace Recipes\Application\Query\Recipes;

class GetRecipesByOwnerQuery
{
    private $ids;
    private $page;
    private $pageSize;
    private $userId;

    public function __construct(
        array $ids,
        ?string $userId,
        int $page = 1,
        int $pageSize = -1
    )
    {
        $this->ids = $ids;
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->userId = $userId;
    }

    public function ids(): array
    {
        return $this->ids;
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