<?php

namespace Recipes\Domain\Model\Category;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;
use LIN3S\SharedKernel\Domain\Model\Identity\Id;
use Recipes\Domain\Model\Translation\Translatable;

class CategoryId extends Id
{
    public static function generate($id = null)
    {
        return new self($id);
    }
}