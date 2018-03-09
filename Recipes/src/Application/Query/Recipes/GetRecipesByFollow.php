<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;

class GetRecipesByFollow
{
    private $view;

    public function __construct(RecipeView $view)
    {
        $this->view = $view;
    }

    public function __invoke(GetRecipesByFollowQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;

        return $this->view->list(
            [
                'follow' => $query->userId()
            ],
            $limit,
            $offset
        );
    }
}