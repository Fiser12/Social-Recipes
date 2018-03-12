<?php

namespace Recipes\Application\Query\Category;

use Recipes\Domain\Model\Category\CategoryView;

class GetCategoriesByIds
{
    private $view;

    public function __construct(CategoryView $view)
    {
        $this->view = $view;
    }

    public function __invoke(GetCategoriesByIdsQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;

        return $this->view->list(
            [
                'ids' => $query->ids(),
            ],
            $limit,
            $offset
        );
    }
}