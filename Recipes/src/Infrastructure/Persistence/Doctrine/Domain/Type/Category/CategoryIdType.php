<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Type\Category;

use Recipes\Infrastructure\Persistence\Doctrine\Domain\Type\DoctrineEntityIdType;

class CategoryIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Category\CategoryId::class;
    }
}