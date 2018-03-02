<?php

namespace Recipes\Domain\Model\User;

use LIN3S\SharedKernel\Domain\Model\Identity\Id;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class UserId extends Id
{
    public static function generate($id = null)
    {
        return new self($id);
    }
}