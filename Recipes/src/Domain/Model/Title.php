<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

/**
 * @author Rubén García <ruben.garcia@opendeusto.es>
 */
class Title
{
    protected $title;

    public function __construct(string $title)
    {
        $this->setTitle($title);
    }

    private function setTitle(string $title): void
    {
        if (empty($title)) {
            throw new DomainException('Title: Cannot be empty');
        }
        $this->title = $title;
    }

    public function title(): string
    {
        return $this->title;
    }
}