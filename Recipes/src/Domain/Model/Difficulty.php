<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

class Difficulty
{
    private $difficulty;

    //TODO Crear un enum
    public function __construct(string $difficulty)
    {
        $this->difficulty = $difficulty;
    }


    public function difficulty() : string
    {
        return $this->difficulty;
    }
}