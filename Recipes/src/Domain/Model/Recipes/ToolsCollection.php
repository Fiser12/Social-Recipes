<?php

/*
 * This file is part of the CMS Kernel package.
 *
 * Copyright (c) 2016-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Recipes\Domain\Model\Recipes;

use Recipes\Domain\Model\Translation\TranslationCollection;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class ToolsCollection extends TranslationCollection
{
    protected function type()
    {
        return Tool::class;
    }
}
