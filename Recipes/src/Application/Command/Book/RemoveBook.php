<?php

namespace Recipes\Application\Command\Book;

use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;

class RemoveBook
{
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RemoveCategoryCommand $command)
    {
        $this->repository->remove(BookId::generate($command->id()));
    }
}