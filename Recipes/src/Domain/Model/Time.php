<?php

namespace Recipes\Domain\Model;

use LIN3S\SharedKernel\Exception\DomainException;

class Time
{
    protected $seconds;

    public function __construct(int $seconds)
    {
        $this->setSeconds($seconds);
    }

    private function setSeconds(int $seconds): void
    {
        if ($seconds <= 0) {
            throw new DomainException('Time: It has to be bigger than 0');
        }
        $this->seconds = $seconds;
    }

    public function seconds() : int
    {
        return $this->seconds;
    }

    public function minutes() : int
    {
        return $this->seconds()/60;
    }

    public function hours() : int
    {
        return $this->minutes()/60;
    }
}