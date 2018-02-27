<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book;

use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\DoctrineEntityIdType;

class BookIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Book\BookId::class;
    }
}