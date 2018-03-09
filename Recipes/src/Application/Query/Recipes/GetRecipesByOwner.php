<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;

class GetRecipesByOwner
{
    private $view;

    public function __construct(RecipeView $view)
    {
        $this->view = $view;
    }

    public function __invoke(GetRecipesByFriendsQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;

        return $this->view->list(
            ['owners' => [$query->userId()]],
            $limit,
            $offset
        );
    }
}