<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Types;

class UserId extends DoctrineEntityId
{
    public function className(): string
    {
        return \Recipes\Domain\Model\User\UserId::class;
    }
}