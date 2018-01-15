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

namespace App\Domain\Model\Session;

class UserFacebookAccessToken
{
    private $token;
    private $createdOn;

    public function __construct(string $token)
    {
        $this->token = $token;
        $this->createdOn = new \DateTimeImmutable();
    }

    public function token() : string
    {
        return $this->token;
    }

    public function createdOn() : \DateTimeImmutable
    {
        return $this->createdOn;
    }

    public function equals(UserFacebookAccessToken $aToken) : bool
    {
        return $this->token === $aToken->token();
    }

    public function isExpired($lifetime) : bool
    {
        $interval = $this->createdOn->diff(new \DateTimeImmutable());

        return $interval->s >= (int) $lifetime;
    }

    public function __toString()
    {
        return $this->token();
    }
}
