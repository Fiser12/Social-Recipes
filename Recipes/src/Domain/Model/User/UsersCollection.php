<?php

namespace Recipes\Domain\Model\User;

use Recipes\Domain\Model\Translation\TranslationCollection;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class UsersCollection extends TranslationCollection
{
    protected function type()
    {
        return UserId::class;
    }
}
