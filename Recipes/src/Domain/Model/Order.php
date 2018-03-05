<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

class Order
{
    protected $order;

    public function __construct(int $order)
    {
        $this->setQuantity($order);
    }

    private function setQuantity(int $order): void
    {
        if ($order >= 0) {
            throw new DomainException('Order: It has to be bigger than 0');
        }
        $this->order = $order;
    }

    public function order() : int
    {
        return $this->order;
    }
}