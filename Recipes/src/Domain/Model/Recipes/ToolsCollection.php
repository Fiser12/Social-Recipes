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

use AurimasNiekis\DoctrineJsonObjectType\JsonObject;
use LIN3S\SharedKernel\Domain\Model\Collection\Collection;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class ToolsCollection extends Collection implements JsonObject
{
    protected function type()
    {
        return Tool::class;
    }

    public static function fromJson(array $data)
    {
        $collections = new self();

        foreach ($data as $item) {
            $tool = new Tool();
            foreach ($item as $translation) {
                $tool->addTranslation(
                    new ToolTranslation(
                        new Locale($translation['locale']),
                        new Name($translation['name'])
                    )
                );
            }
            $collections->add($tool);
        }

        return $collections;
    }

    public function jsonSerialize()
    {
        $jsonCollection = [];

        foreach ($this->toArray() as $item) {
            $jsonObject = [];

            foreach ($item->translations() as $translation) {
                $jsonObject[] = [
                    'name' => $translation->name()->name(),
                    'locale' => $translation->locale()->locale()
                ];
            }
            $jsonCollection[] = $jsonObject;
        }

        return $jsonCollection;
    }
}
