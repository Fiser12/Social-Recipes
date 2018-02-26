<?php

/*
 * This file is part of the CMS Kernel package.
 *
 * Copyright (c) 2016-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Recipes\Domain\Model\Translation;

use LIN3S\SharedKernel\Exception\Exception;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class DifficultyIsInvalid extends Exception
{
    public function __construct(string $str)
    {
        parent::__construct('The difficulty '.$str.' is invalid');
    }
}
