<?php

namespace Recipes\Application\Query\Recipes;

class GetRecipesByCategoriesQuery
{
    private $categoryIds;
    private $page;
    private $pageSize;
    private $userId;

    public function __construct(
        ?string $userId,
        array $categoryIds,
        int $page = 1,
        int $pageSize = -1
    )
    {
        $this->categoryIds = $categoryIds;
        $this->page = $page;
        $this->pageSize = $pageSize;
        $this->userId = $userId;
    }

    public function categoryIds(): array
    {
        return $this->categoryIds;
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