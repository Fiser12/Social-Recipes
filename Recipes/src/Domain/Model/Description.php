<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

class Description
{
    private $description;

    public function __construct(string $description)
    {
        $this->setDescription($description);
    }

    private function setDescription(string $description): void
    {
        if (empty($description)) {
            throw new DomainException('Description: Cannot be empty');
        }
        $this->description = $description;
    }

    public function description(): string
    {
        return $this->description;
    }
}