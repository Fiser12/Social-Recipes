<?php

namespace Recipes\Application\Query\Book;

use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookView;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;

class GetBooksByIds
{
    private $view;
    private $userRepository;

    public function __construct(BookView $view, UserRepository $userRepository)
    {
        $this->view = $view;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetBooksByIdsQuery $query): array
    {
        return array_merge(
            $this->friendsRecipes($query),
            $this->ownerBooks($query)
        );
    }

    private function friendsRecipes(GetBooksByIdsQuery $query): array
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

    private function ownerBooks(GetBooksByIdsQuery $query): array
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