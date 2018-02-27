<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Category;

use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\DoctrineEntityIdType;

class CategoryIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Category\CategoryId::class;
    }
}