<?php

namespace Recipes\Application\Query\Book;

use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookView;
use Recipes\Domain\Model\Scope;

class GetBooksByFriends
{
    private $view;

    public function __construct(BookView $view)
    {
        $this->view = $view;
    }

    public function __invoke(GetBooksByFriendsQuery $query): array
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