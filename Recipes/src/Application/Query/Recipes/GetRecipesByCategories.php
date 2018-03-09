<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;
use Recipes\Domain\Model\Scope;

class GetRecipesByCategories
{
    private $view;

    public function __construct(RecipeView $view)
    {
        $this->view = $view;
    }

    public function __invoke(GetRecipesByCategoriesQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;

        return $this->view->list(
            [
                'categories' => $query->categoryIds(),
                'scopes' => [Scope::PUBLIC]
            ],
            $limit,
            $offset
        );
    }
}