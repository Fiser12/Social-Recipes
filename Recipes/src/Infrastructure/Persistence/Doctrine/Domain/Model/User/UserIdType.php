<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\User;

use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\DoctrineEntityIdType;

class UserIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\User\UserId::class;
    }
}