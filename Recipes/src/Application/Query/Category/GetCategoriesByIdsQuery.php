<?php

namespace Recipes\Application\Query\Category;

class GetCategoriesByIdsQuery
{
    private $ids;
    private $page;
    private $pageSize;

    public function __construct(
        array $ids,
        int $page = 1,
        int $pageSize = -1
    )
    {
        $this->ids = $ids;
        $this->page = $page;
        $this->pageSize = $pageSize;
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
}