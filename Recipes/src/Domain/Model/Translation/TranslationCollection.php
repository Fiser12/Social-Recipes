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

use LIN3S\SharedKernel\Domain\Model\Collection\Collection;
use LIN3S\SharedKernel\Domain\Model\Collection\CollectionElementAlreadyAddedException;

/**
 * @author Beñat Espiña <benatespina@gmail.com>
 */
class TranslationCollection extends Collection
{
    protected function type()
    {
        return Translation::class;
    }

    public function add($translation): void
    {
        $translations = $this->toArray();
        foreach ($translations as $trans) {
            if ($translation->locale()->equals($trans->locale())) {
                throw new CollectionElementAlreadyAddedException();
            }
        }
        parent::add($translation);
    }

    public function contains($element): bool
    {
        foreach ($this->toArray() as $el) {
            if ($element->locale()->equals($el->locale())) {
                return true;
            }
        }

        return false;
    }

}
