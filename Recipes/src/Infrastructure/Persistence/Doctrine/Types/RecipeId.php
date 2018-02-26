<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Types;

class RecipeId extends DoctrineEntityId
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Recipes\RecipeId::class;
    }
}