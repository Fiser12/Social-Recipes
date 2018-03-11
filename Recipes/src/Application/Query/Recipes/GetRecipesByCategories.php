<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;

class GetRecipesByCategories
{
    private $view;
    private $userRepository;

    public function __construct(RecipeView $view, UserRepository $userRepository)
    {
        $this->view = $view;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetRecipesByCategoriesQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;

        $result =  array_merge(
            $this->friendsRecipes($query),
            $this->ownerRecipes($query)
        );

        return -1 === $limit ? $result : array_splice($result, $offset, $limit);
    }

    private function friendsRecipes(GetRecipesByCategoriesQuery $query): array
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
                'categories' => $query->categoryIds(),
                'scopes' => [
                    Scope::PUBLIC,
                    Scope::PROTECTED
                ],
                'owners' => $friends
            ]
        );
    }

    private function ownerRecipes(GetRecipesByCategoriesQuery $query): array
    {
        $result = $this->view->list(
            [
                'categories' => $query->categoryIds(),
                'scopes' => [Scope::PUBLIC]
            ]
        );

        if (!empty($query->userId())) {
            $result = array_merge($result, $this->view->list(
                [
                    'categories' => $query->categoryIds(),
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
        $friendsCollection = $this->userRepository->userOfId(UserId::generate($userId))->friends()->toArray();

        foreach ($friendsCollection as $friend) {
            $friends[] = $friend->id();
        }
        return $friends;
    }
}