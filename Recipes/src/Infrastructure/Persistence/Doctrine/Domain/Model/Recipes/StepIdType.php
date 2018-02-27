<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Recipes;

use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\DoctrineEntityIdType;

class StepIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Recipes\StepId::class;
    }
}