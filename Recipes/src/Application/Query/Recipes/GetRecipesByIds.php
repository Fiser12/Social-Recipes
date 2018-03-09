<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;
use Recipes\Domain\Model\Scope;

class GetRecipesByIds
{
    private $view;

    public function __construct(RecipeView $view)
    {
        $this->view = $view;
    }

    public function __invoke(GetRecipesByIdsQuery $query): array
    {
        return array_merge(
            $this->friendsRecipes($query),
            $this->ownerRecipes($query)
        );
    }

    private function friendsRecipes(GetRecipesByIdsQuery $query): array
    {
        return $this->view->list(
            [
                'ids' => $query->ids(),
                'scopes' => $query->userId() !== null
                    ? [
                        Scope::PUBLIC,
                        Scope::PROTECTED
                    ]
                    : [Scope::PUBLIC],
                'owners' => $this->friends($query->userId())
            ]
        );
    }

    private function ownerRecipes(GetRecipesByIdsQuery $query): array
    {
        return $this->view->list(
            [
                'ids' => $query->ids(),
                'owners' => [$query->userId()]
            ]
        );
    }

    private function friends(?string $userId): array
    {
        if ($userId) {
            //TODO Call to api rest of session and get the friends
            return [];
        }
        return [];
    }
}