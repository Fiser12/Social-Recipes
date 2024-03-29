<?php

namespace Recipes\Application\Query\Category;

use Recipes\Domain\Model\Category\CategoryView;

class GetCategories
{
    private $view;

    public function __construct(CategoryView $view)
    {
        $this->view = $view;
    }

    public function __invoke(GetCategoriesQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;

        return $this->view->list(
            [],
            $limit,
            $offset
        );
    }
}