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
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class TranslationDoesNotExistException extends Exception
{
    public function __construct($locale)
    {
        parent::__construct(
            sprintf(
                'Translation of the given %s locale does not exist',
                $locale
            )
        );
    }
}
