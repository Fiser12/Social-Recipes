<?php

/*
 * This file is part of the Social Recipes project.
 *
 * Copyright (c) 2017 LIN3S <ruben@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Application\DataTransformer\User;

use BenGorUser\User\Application\DataTransformer\UserDTODataTransformer;

/**
 * @author José Elías Gutiérrez <jose@lin3s.com>
 */
class UserDTODataTransform extends UserDTODataTransformer
{
    public function read() : array
    {
        $readParent = parent::read();

        $firstName = null;
        $lastName = null;
        $name = null;

        return array_merge($readParent, [
            'facebook_id' => $this->user->facebookId(),
            'name'        => $name,
            'first_name'  => $firstName,
            'last_name'   => $lastName,
        ]);
    }
}
