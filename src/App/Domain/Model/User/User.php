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

namespace App\Domain\Model\User;

use BenGorUser\User\Domain\Model\Event\UserLoggedIn;
use BenGorUser\User\Domain\Model\User as BaseUser;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserPassword;
use BenGorUser\User\Domain\Model\UserRole;

class User extends BaseUser
{
    private const ROLE_CLIENT = 'ROLE_CLIENT';

    private $facebookId;

    public function __construct(
        UserId $anId,
        UserEmail $anEmail,
        UserPassword $aPassword = null,
        string $facebookId = null
    ) {
        $userRoles = array_map(function ($role) {
            return new UserRole($role);
        }, self::availableRoles());

        parent::__construct($anId, $anEmail, $userRoles, $aPassword);

        if (null !== $facebookId) {
            $this->connectToFacebook($facebookId);
        }
    }

    public function facebookId() : ?string
    {
        return $this->facebookId;
    }


    public static function signUpWithFacebook(
        UserId $id,
        string $facebookId,
        UserEmail $email
    ) : self {
        $client = new self($id, $email, null, $facebookId);

        $client->publish(
            new UserRegisteredWithFacebook(
                $client->id(),
                $client->facebookId(),
                $client->email()
            )
        );

        return $client;
    }
    public static function signUp(UserId $anId, UserEmail $anEmail, UserPassword $aPassword, array $userRoles){

    }

    public function connectToFacebook(string $facebookId) : void
    {
        $this->facebookId = $facebookId;
        $this->lastLogin = new \DateTimeImmutable();

        $this->publish(
            new UserLoggedIn(
                $this->id,
                $this->email
            )
        );
    }

    public static function availableRoles() : array
    {
        return [
            self::ROLE_CLIENT,
        ];
    }
}

