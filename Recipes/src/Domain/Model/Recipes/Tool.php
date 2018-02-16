<?php

namespace Recipes\Domain\Model\Recipes;

use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Quantity;

class Tool
{
    private $name;

    private function __construct(Name $name)
    {
        $this->name = $name;
    }

    public function name(): Name
    {
        return $this->name;
    }
}