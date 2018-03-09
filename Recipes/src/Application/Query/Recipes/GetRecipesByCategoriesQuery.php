<?php

namespace Recipes\Application\Query\Recipes;

class GetRecipesByCategoriesQuery
{
    private $categoryIds;
    private $page;
    private $pageSize;

    public function __construct(
        array $categoryIds,
        int $page = 1,
        int $pageSize = -1
    )
    {
        $this->categoryIds = $categoryIds;
        $this->page = $page;
        $this->pageSize = $pageSize;
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

}