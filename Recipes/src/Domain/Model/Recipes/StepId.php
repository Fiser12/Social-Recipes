<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\Identity\Id;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class StepId extends Id
{
    public static function generate($id = null)
    {
        return new self($id);
    }
}