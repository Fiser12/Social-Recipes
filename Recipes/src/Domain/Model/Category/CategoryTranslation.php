<?php

namespace Recipes\Domain\Model\Category;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Translation\Translation;

class CategoryTranslation extends Translation
{
    protected $name;

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