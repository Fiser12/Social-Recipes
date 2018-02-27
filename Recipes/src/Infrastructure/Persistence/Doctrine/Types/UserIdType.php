<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Types;

class UserIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\User\UserId::class;
    }
}