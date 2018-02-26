<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Types;

class BookId extends DoctrineEntityId
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Book\BookId::class;
    }
}