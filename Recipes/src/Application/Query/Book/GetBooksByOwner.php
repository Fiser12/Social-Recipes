<?php

namespace Recipes\Application\Query\Book;

use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookView;
use Recipes\Domain\Model\Scope;

class GetBooksByOwner
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
            ['owners' => [$query->userId()]],
            $limit,
            $offset
        );
    }
}