<?php

namespace Recipes\Domain\Model\Recipes;

use AurimasNiekis\DoctrineJsonObjectType\JsonObject;
use LIN3S\SharedKernel\Domain\Model\Collection\Collection;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class IngredientsCollection extends Collection implements JsonObject
{
    protected function type()
    {
        return Ingredient::class;
    }

    public static function fromJson(array $data)
    {
        $collections = new self();

        foreach ($data as $item) {
            $collections->add(new Ingredient($item['quantity']));
        }

        return $collections;
    }

    public function jsonSerialize()
    {
        $jsonCollection = [];
        foreach ($this->toArray() as $item) {
            /** @var Ingredient $item */
            $jsonCollection[] = [
                'quantity' => $item->quantity()->quantity()
            ];
        }

        return $jsonCollection;
    }
}
