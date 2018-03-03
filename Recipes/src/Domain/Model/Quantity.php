<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

//TODO Distitnos tipos de magnitudes por ejemplo gramos|kilos|cucharadas
class Quantity
{
    private $quantity;

    public function __construct(int $quantity)
    {
        $this->setQuantity($quantity);
    }

    private function setQuantity(int $quantity): void
    {
        if ($quantity <= 0) {
            throw new DomainException('Quantity: It has to be bigger than 0');
        }
        $this->quantity = $quantity;
    }

    public function quantity() : double
    {
        return $this->quantity;
    }
}