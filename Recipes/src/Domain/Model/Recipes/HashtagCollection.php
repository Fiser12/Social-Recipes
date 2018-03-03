<?php

namespace Recipes\Domain\Model\Recipes;

use AurimasNiekis\DoctrineJsonObjectType\JsonObject;
use LIN3S\SharedKernel\Domain\Model\Collection\Collection;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class HashtagCollection extends Collection implements JsonObject
{
    protected function type()
    {
        return Hashtag::class;
    }

    public static function fromJson(array $data)
    {
        $collections = new self();
        foreach ($data as $item) {
            $collections->add(new Hashtag($item['hashtag']));
        }

        return $collections;
    }

    public function jsonSerialize()
    {
        $jsonCollection = [];
        foreach ($this->toArray() as $item) {
            /** @var Hashtag $item */
            $jsonCollection[] = [
                'hashtag' => $item->hashtag()
            ];
        }

        return $jsonCollection;
    }

}
