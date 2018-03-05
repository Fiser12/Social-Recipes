<?php

namespace Recipes\Domain\Model\Recipes;

use LIN3S\SharedKernel\Exception\DomainException;

class Servings
{
    protected $servings;

    public function __construct(int $servings)
    {
        $this->setServings($servings);
    }

    private function setServings(int $servings): void
    {
        if ($servings <= 0) {
            throw new DomainException('Servings: It has to be bigger than 0');
        }
        $this->servings = $servings;
    }

    public function servings() : int
    {
        return $this->servings;
    }
}