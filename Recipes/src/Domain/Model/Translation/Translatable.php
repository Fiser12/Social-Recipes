<?php

/*
 * This file is part of the CMS Kernel library.
 *
 * Copyright (c) 2016 LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Recipes\Domain\Model\Translation;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;

/**
 * @author Beñat Espiña <benatespina@gmail.com>
 */
abstract class Translatable
{
    protected $translations;

    public function __construct()
    {
        $this->translations = new TranslationCollection();
    }

    public function translations(): TranslationCollection
    {
        return new TranslationCollection($this->translations->getValues());
    }

    public function addTranslation(Translation $translation): void
    {
        if(get_class($translation)!==$this->translationClass()) {
            throw new InvalidTranslationClass();
        }

        $translationReflection = new \ReflectionClass($translation);
        $origin = $translationReflection->getProperty('origin');
        $origin->setAccessible(true);
        $origin->setValue($translation, $this);

        $this->translations->add($translation);
    }

    public function removeTranslation(Locale $locale): void
    {
        foreach ($this->translations as $translation) {
            if ($locale->equals($translation->locale())) {
                return $this->translations->removeElement($translation);
            }
        }
        throw new TranslationDoesNotExistException($locale->locale());
    }

    public function __call($locale, $args)
    {
        $resultTranslation = null;
        foreach ($this->translations() as $translation) {
            if ($translation->locale()->equals(new Locale($locale))) {
                $resultTranslation = $translation;
                break;
            }
        }

        if (!$resultTranslation instanceof Translation) {
            throw new TranslationDoesNotExistException($locale);
        }

        return $resultTranslation;
    }

    abstract protected function translationClass(): string;
}
