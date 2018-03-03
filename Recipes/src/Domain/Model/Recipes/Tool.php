<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Quantity;
use Recipes\Domain\Model\Translation\Translatable;

class Tool
{
    use Translatable{
        Translatable::__construct as private __translatableConstruct;
    }

    public function __construct()
    {
        $this->__translatableConstruct();
    }

    protected function translationClass(): string
    {
        return ToolTranslation::class;
    }
}