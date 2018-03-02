<?php

namespace Recipes\Domain\Model\Book;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;
use LIN3S\SharedKernel\Domain\Model\Identity\Id;
use Recipes\Domain\Model\Translation\Translatable;

class BookId extends Id
{
    public static function generate($id = null)
    {
        return new self($id);
    }
}