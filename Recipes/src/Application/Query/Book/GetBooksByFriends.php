<?php

namespace Recipes\Application\Query\Book;

use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookView;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;

class GetBooksByFriends
{
    private $view;
    private $userRepository;

    public function __construct(BookView $view, UserRepository $userRepository)
    {
        $this->view = $view;
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetBooksByFriendsQuery $query): array
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
                'owners' => $friends->toArray()
            ],
            $limit,
            $offset
        );
    }
}