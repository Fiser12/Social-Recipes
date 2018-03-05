<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;
use Recipes\Domain\Model\User\UserId;

abstract class DoctrineEntityIdType extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if($value === null){
            return null;
        }

        return $value->id();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if($value === null){
            return null;
        }

        $className = $this->className();
        return $className::generate($value);
    }

    abstract public function className(): string;
}