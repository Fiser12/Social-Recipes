<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

abstract class Icon
{
    protected $icon;

    public function __construct(string $icon)
    {
        $this->setIcon($icon);
    }

    private function setIcon(string $icon): void
    {
        if (empty($icon)) {
            throw new DomainException(self::class . ': Cannot be empty');
        }

        if (!in_array($icon, $this->validIcons())) {
            throw new DomainException(self::class . ': Invalid icon');
        }

        $this->icon = $icon;
    }

    public function icon(): string
    {
        return $this->icon;
    }

    abstract protected function validIcons(): array;
}