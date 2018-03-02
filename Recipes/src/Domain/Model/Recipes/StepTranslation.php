<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Description;
use Recipes\Domain\Model\Translation\Translation;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class StepTranslation extends Translation
{
    private $description;

    public function __construct(Locale $locale, Description $description)
    {
        parent::__construct($locale);
        $this->description = $description;
    }

    public function description(): Description
    {
        return $this->description;
    }
}