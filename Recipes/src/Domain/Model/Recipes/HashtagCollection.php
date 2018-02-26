<?php

namespace Recipes\Domain\Model\Recipes;

use Recipes\Domain\Model\Translation\TranslationCollection;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class HashtagCollection extends TranslationCollection
{
    protected function type()
    {
        return Hashtag::class;
    }
}
