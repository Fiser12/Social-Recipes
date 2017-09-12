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

class UserFacebookAccessToken
{
    /**
     * The id in a primitive type.
     *
     * @var string|int
     */
    private $token;

    /**
     * The created on.
     *
     * @var \DateTimeImmutable
     */
    private $createdOn;

    /**
     * Constructor.
     *
     * @param string $token User facebook access token
     */
    public function __construct($token)
    {
        $this->token = $token;
        $this->createdOn = new \DateTimeImmutable();
    }

    /**
     * Gets the id.
     *
     * @return string|int
     */
    public function token()
    {
        return $this->token;
    }

    /**
     * Gets the created on.
     *
     * @return \DateTimeImmutable
     */
    public function createdOn()
    {
        return $this->createdOn;
    }

    /**
     * Method that checks if the id given is equal to the current.
     *
     * @param UserFacebookAccessToken $aToken The token
     *
     * @return bool
     */
    public function equals(UserFacebookAccessToken $aToken)
    {
        return $this->token === $aToken->token();
    }

    /**
     * Checks if the token is expired comparing
     * with the given lifetime.
     *
     * @param int $lifetime The lifetime of the token
     *
     * @return bool
     */
    public function isExpired($lifetime)
    {
        $interval = $this->createdOn->diff(new \DateTimeImmutable());

        return $interval->s >= (int) $lifetime;
    }

    /**
     * Magic method that represents the token in string format.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->token();
    }
}
