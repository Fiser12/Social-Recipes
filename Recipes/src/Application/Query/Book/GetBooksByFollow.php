<?php

namespace Recipes\Application\Query\Book;

use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookView;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;

class GetBooksByFollow
{
    private $view;
    private $userRepository;

    public function __construct(BookView $view, UserRepository $userRepository)
    {
        $this->view = $view;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetBooksByFollowQuery $query): array
    {
        $limit = $query->pageSize();
        $offset = ($query->page() - 1) * $limit;

        $friends = $this->friends($query->followId());
        if (!empty($friends) && in_array($query->followId(), $friends)) {
            $result = $this->view->list(
                [
                    'scopes' => [
                        Scope::PUBLIC,
                        Scope::PROTECTED
                    ],
                    'owners' => $query->followId()
                ]
            );
        } else {
            $result = $this->view->list(
                [
                    'follow' => $query->followId(),
                    'scopes' => [Scope::PUBLIC]
                ]
            );
        }

        if($query->userId() == $query->followId()) {
            $result = $this->view->list(
                [
                    'follow' => $query->followId(),
                ],
                $limit,
                $offset
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