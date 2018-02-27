<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Type\Recipes;

use Recipes\Infrastructure\Persistence\Doctrine\Domain\Type\DoctrineEntityIdType;

class RecipeIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Recipes\RecipeId::class;
    }
}