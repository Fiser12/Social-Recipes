<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Domain\Model\User;

class LastName
{
    private $lastName;

    public function __construct(string $lastName)
    {
        $this->saveLastName($lastName);
    }

    public function lastName() : string
    {
        return $this->lastName;
    }

    protected function saveLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }
}