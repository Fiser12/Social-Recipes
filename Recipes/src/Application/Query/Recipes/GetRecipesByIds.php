<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;

class GetRecipesByIds
{
    private $view;
    private $userRepository;

    public function __construct(RecipeView $view, UserRepository $userRepository)
    {
        $this->view = $view;
        $this->userRepository = $userRepository;
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
        $friends = $this->userRepository->userOfId(UserId::generate($query->userId()))->friends();

        return $this->view->list(
            [
                'ids' => $query->ids(),
                'scopes' => $query->userId() !== null
                    ? [
                        Scope::PUBLIC,
                        Scope::PROTECTED
                    ]
                    : [Scope::PUBLIC],
                'owners' => $friends
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
}