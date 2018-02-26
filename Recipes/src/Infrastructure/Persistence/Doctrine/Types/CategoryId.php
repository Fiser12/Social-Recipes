<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Types;

class CategoryId extends DoctrineEntityId
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Category\CategoryId::class;
    }
}