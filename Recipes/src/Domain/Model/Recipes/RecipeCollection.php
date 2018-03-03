<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\Collection\Collection;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class RecipeCollection extends Collection
{
    protected function type()
    {
        return RecipeId::class;
    }
}
