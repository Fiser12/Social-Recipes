<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Types;

class StepIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\Recipes\StepId::class;
    }
}