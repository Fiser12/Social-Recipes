<?php

namespace Recipes\Domain\Model\Recipes;

use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Quantity;

class Ingredient
{
    private $name;
    private $quantity;

    private function __construct(Name $name, Quantity $quantity)
    {
        $this->name = $name;
        $this->quantity = $quantity;
    }

    public function name(): Name
    {
        return $this->name;
    }

    public function quantity(): Quantity
    {
        return $this->quantity;
    }
}