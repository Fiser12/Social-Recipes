<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Recipes;

use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\DoctrineEntityIdType;

class RecipeIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Recipes\RecipeId::class;
    }
}