<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Types;

class RecipeIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Recipes\RecipeId::class;
    }
}