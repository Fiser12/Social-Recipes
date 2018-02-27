<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Types;

class CategoryIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Category\CategoryId::class;
    }
}