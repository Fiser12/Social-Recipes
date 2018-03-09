<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;
use Recipes\Domain\Model\Scope;

class GetRecipesByBooks
{
    private $view;

    public function __construct(RecipeView $view)
    {
        $this->view = $view;
    }

    //TODO Considerar que sea mi propio book
    public function __invoke(GetRecipesByBooksQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;

        return $this->view->list(
            [
                'books' => $query->bookIds(),
                'scopes' => [Scope::PUBLIC]
            ],
            $limit,
            $offset
        );
    }
}