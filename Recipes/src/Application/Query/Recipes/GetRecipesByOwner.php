<?php

namespace Recipes\Application\Query\Recipes;

use Recipes\Domain\Model\Recipes\RecipeView;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;

class GetRecipesByOwner
{
    private $view;
    private $userRepository;

    public function __construct(RecipeView $view, UserRepository $userRepository)
    {
        $this->view = $view;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetRecipesByOwnerQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;

        $friends = $this->friends($query->userId());

        if (!empty($friends) && in_array($query->ownerId(), $friends)) {
            $result = $this->view->list(
                [
                    'scopes' => [
                        Scope::PUBLIC,
                        Scope::PROTECTED
                    ],
                    'owners' => [$query->ownerId()]
                ]
            );
        } else {
            $result = $this->view->list(
                [
                    'owners' => [$query->ownerId()],
                    'scopes' => [Scope::PUBLIC]
                ]
            );
        }

        if($query->ownerId() === $query->userId()) {
            $result = $this->view->list(
                ['owners' => [$query->userId()]]
            );
        }

        return -1 === $limit ? $result : array_splice($result, $offset, $limit);
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