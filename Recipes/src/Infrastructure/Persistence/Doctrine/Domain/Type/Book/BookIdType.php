<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Type\Book;

use Recipes\Infrastructure\Persistence\Doctrine\Domain\Type\DoctrineEntityIdType;

class BookIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Book\BookId::class;
    }
}