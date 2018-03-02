<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Translation\Translation;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class ToolTranslation extends Translation
{
    private $name;

    public function __construct(Locale $locale, Name $name)
    {
        parent::__construct($locale);
        $this->name = $name;
    }

    public function name(): Name
    {
        return $this->name;
    }
}