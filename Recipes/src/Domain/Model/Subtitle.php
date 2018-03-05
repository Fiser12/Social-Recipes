<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class Subtitle
{
    protected $subtitle;

    public function __construct(string $subtitle)
    {
        $this->setSubtitle($subtitle);
    }

    private function setSubtitle(string $subtitle): void
    {
        if (empty($subtitle)) {
            throw new DomainException('Subtitle: Cannot be empty');
        }
        $this->subtitle = $subtitle;
    }

    public function subtitle(): string
    {
        return $this->subtitle;
    }
}