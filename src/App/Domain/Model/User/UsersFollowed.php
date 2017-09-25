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

use BenGorUser\User\Domain\Model\UserId;
use LIN3S\SharedKernel\Domain\Model\Collection\Collection;

class UsersFollowed extends Collection
{
    protected function type()
    {
        return User::class;
    }
}