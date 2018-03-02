<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Type\User;

use Recipes\Infrastructure\Persistence\Doctrine\Domain\Type\DoctrineEntityIdType;

class UserIdType extends DoctrineEntityIdType
{
    public function className(): string
    {
        return \Recipes\Domain\Model\User\UserId::class;
    }
}