<?php

namespace Recipes\Application\Query\Book;

use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookView;
use Recipes\Domain\Model\Scope;

class GetBooksByIds
{
    private $view;

    public function __construct(BookView $view)
    {
        $this->view = $view;
    }

    public function __invoke(GetBooksByIdsQuery $query): array
    {
        return array_merge(
            $this->friendsRecipes($query),
            $this->ownerRecipes($query)
        );
    }

    private function friendsRecipes(GetBooksByIdsQuery $query): array
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

    private function ownerRecipes(GetBooksByIdsQuery $query): array
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