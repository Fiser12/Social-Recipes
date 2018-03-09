<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;

class GetRecipesByFriends
{
    private $view;
    private $userRepository;

    public function __construct(RecipeView $view, UserRepository $userRepository)
    {
        $this->view = $view;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetRecipesByFriendsQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;
        $friends = $this->userRepository->userOfId(UserId::generate($query->userId()))->friends();

        return $this->view->list(
            [
                'scopes' => $query->userId() !== null
                    ? [
                        Scope::PUBLIC,
                        Scope::PROTECTED
                    ]
                    : [Scope::PUBLIC],
                'owners' => $friends
            ],
            $limit,
            $offset
        );
    }
}