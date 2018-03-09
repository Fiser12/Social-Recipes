<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;
use Recipes\Domain\Model\Scope;

class GetRecipesByFriends
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
            [
                'scopes' => $query->userId() !== null
                    ? [
                        Scope::PUBLIC,
                        Scope::PROTECTED
                    ]
                    : [Scope::PUBLIC],
                'owners' => $this->friends($query->userId())
            ],
            $limit,
            $offset
        );
    }

    private function friends(?string $userId): array
    {
        if ($userId) {
            //TODO Call to api rest of session and get the friends
            return [$userId];
        }
        return [];
    }
}