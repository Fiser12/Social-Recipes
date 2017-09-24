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

namespace App\Application\Command\SignUp;

/**
 * @author Beñat Espiña <bespina@lin3s.com>
 */
class FacebookLogInClientCommand
{
    private $facebookId;
    private $email;

    public function __construct(string $facebookId, string $email)
    {
        $this->facebookId = $facebookId;
        $this->email = $email;
    }

    public function facebookId() : string
    {
        return $this->facebookId;
    }

    public function email() : string
    {
        return $this->email;
    }
}
