<?php

namespace Recipes\Application\Command\Book;

use LIN3S\SharedKernel\Exception\Exception;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\User\UserId;

class RemoveBook
{
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RemoveBookCommand $command)
    {
        $book = $this->repository->bookOfId(BookId::generate($command->id()));

        if($book === null || !$book->owner()->equals(UserId::generate($command->userId()))) {
            throw new Exception('Invalid userId, is not your book');
        }
        $this->repository->remove(BookId::generate($command->id()));
    }
}