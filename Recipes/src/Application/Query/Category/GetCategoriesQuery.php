<?php

namespace Recipes\Application\Query\Category;

class GetCategoriesQuery
{
    private $page;
    private $pageSize;

    public function __construct(int $page = 1, int $pageSize = -1)
    {
        $this->page = $page;
        $this->pageSize = $pageSize;
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