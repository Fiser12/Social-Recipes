<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Description;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Subtitle;
use Recipes\Domain\Model\Title;
use Recipes\Domain\Model\Translation\Translation;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class RecipeTranslation extends Translation
{
    private $title;
    private $subtitle;
    private $description;

    public function __construct(Locale $locale, Title $title, ?Subtitle $subtitle = null, Description $description)
    {
        parent::__construct($locale);
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->description = $description;
    }

    public function title(): Title
    {
        return $this->title;
    }

    public function subtitle(): ?Subtitle
    {
        return $this->subtitle;
    }

    public function description(): Description
    {
        return $this->description;
    }
}