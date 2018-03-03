<?php

namespace Recipes\Domain\Model\User;

use LIN3S\SharedKernel\Domain\Model\Collection\Collection;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class UsersCollection extends Collection
{
    protected function type()
    {
        return UserId::class;
    }
}
