<?php

namespace Recipes\Domain\Model\Recipes;

use Recipes\Domain\Model\Quantity;
use Recipes\Domain\Model\Translation\Translatable;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class Ingredient extends Translatable
{
    private $quantity;

    public function __construct(Quantity $quantity)
    {
        parent::__construct();
        $this->quantity = $quantity;
    }

    public function quantity(): Quantity
    {
        return $this->quantity;
    }

    protected function translationClass(): string
    {
        return IngredientTranslation::class;
    }
}