<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Types;

class BookIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Book\BookId::class;
    }
}