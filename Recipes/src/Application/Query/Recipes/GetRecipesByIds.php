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
        if (empty($query->userId())) {
            return [];
        }

        $friends = $this->friends($query->userId());

        if (empty($friends)) {
            return [];
        }

        return $this->view->list(
            [
                'ids' => $query->ids(),
                'scopes' => [
                    Scope::PUBLIC,
                    Scope::PROTECTED
                ],
                'owners' => $friends
            ]
        );
    }

    private function ownerRecipes(GetRecipesByIdsQuery $query): array
    {
        $result = $this->view->list(
            [
                'ids' => $query->ids(),
                'scopes' => [Scope::PUBLIC]
            ]
        );

        if (!empty($query->userId())) {
            $result = array_merge($result, $this->view->list(
                [
                    'ids' => $query->ids(),
                    'owners' => [$query->userId()]
                ]
            )
            );
        }

        return $result;
    }

    private function friends(string $userId): array
    {
        $friends = [];
        $user = $this->userRepository->userOfId(UserId::generate($userId));
        if($userId === null) {
            return $friends;
        }

        $friendsCollection = $user->friends()->toArray();

        foreach ($friendsCollection as $friend) {
            $friends[] = $friend->id();
        }
        return $friends;
    }
}