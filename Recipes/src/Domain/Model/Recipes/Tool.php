<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Quantity;
use Recipes\Domain\Model\Translation\Translatable;

class Tool extends Translatable
{
    public function __construct()
    {
        parent::__construct();
    }

    protected function translationClass(): string
    {
        return ToolTranslation::class;
    }
}