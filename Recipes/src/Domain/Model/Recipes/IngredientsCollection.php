<?php

namespace Recipes\Domain\Model\Recipes;

use AurimasNiekis\DoctrineJsonObjectType\JsonObject;
use LIN3S\SharedKernel\Domain\Model\Collection\Collection;
use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Quantity;

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
            $ingredient = new Ingredient(
                new Quantity($item['quantity'])
            );
            foreach($item['translations'] as $translation) {
                $ingredient->addTranslation(
                    new IngredientTranslation(
                        new Locale($translation['locale']),
                        new Name($translation['name'])
                    )
                );
            }
            $collections->add($ingredient);
        }

        return $collections;
    }

    public function jsonSerialize() : array
    {
        $jsonCollection = [];
        foreach ($this->toArray() as $item) {
            $translations = [];
            foreach($item->translations() as $translation)
            {
                $translations[] = [
                    'name' => $translation->name()->name(),
                    'locale' => $translation->locale()->locale()
                ];
            }

            /** @var Ingredient $item */
            $jsonCollection[] = [
                'quantity' => $item->quantity()->quantity(),
                'translations' => $translations
            ];
        }

        return $jsonCollection;
    }
}
