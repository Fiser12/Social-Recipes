<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

class Name
{
    private $name;

    public function __construct(string $name)
    {
        $this->setName($name);
    }

    private function setName(string $name): void
    {
        if (empty($name)) {
            throw new DomainException('Name: Cannot be empty');
        }
        $this->name = $name;
    }

    public function name(): string
    {
        return $this->name;
    }
}