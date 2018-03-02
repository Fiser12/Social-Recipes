<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\GuidType;

abstract class DoctrineEntityIdType extends GuidType
{
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value->id();
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $className = $this->className();
        return new $className($value);
    }

    abstract public function className(): string;
}