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

namespace CompositeUi\Domain\Model\Session;

use Symfony\Component\Security\Core\User\UserInterface;

class User implements UserInterface
{
    private $facebookId;
    private $userEmail;
    private $fullName;
    private $jwt;

    public function __construct(
        UserFacebookId $facebookId,
        UserEmail $userEmail,
        FullName $fullName,
        string $jwt
    )
    {
        $this->facebookId = $facebookId;
        $this->userEmail = $userEmail;
        $this->fullName = $fullName;
        $this->jwt = $jwt;
    }

    public function getRoles()
    {
        return ['ROLE_USER'];
    }

    public function getPassword()
    {

    }

    public function getSalt()
    {

    }

    public function getUsername()
    {
        return $this->userEmail->email();
    }

    public function eraseCredentials()
    {
        return;
    }

    public function facebookId(): UserFacebookId
    {
        return $this->facebookId;
    }

    public function email(): UserEmail
    {
        return $this->userEmail;
    }

    public function fullName(): FullName
    {
        return $this->fullName;
    }

    public function jwt() : string
    {
        return $this->jwt;
    }

}

