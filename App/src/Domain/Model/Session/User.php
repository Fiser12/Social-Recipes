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
    private $usersFollowed;
    private $facebookAccessToken;
    private $fullName;

    public function __construct(
        UserId $anId,
        UserEmail $anEmail,
        ?FullName $fullName = null,
        UserPassword $aPassword = null,
        UserFacebookId $facebookId = null,
        UserFacebookAccessToken $facebookAccessToken = null,
        UsersFollowed $usersFollowed = null
    )
    {
        $userRoles = array_map(function ($role) {
            return new UserRole($role);
        }, self::availableRoles());

        parent::__construct($anId, $anEmail, $userRoles, $aPassword);

        if (null !== $facebookId) {
            $this->connectToFacebook($facebookId, $facebookAccessToken);
        }
        $this->usersFollowed = $usersFollowed;
        $this->facebookAccessToken = $facebookAccessToken;
        $this->fullName = $fullName;
    }

    public function facebookId(): ?UserFacebookId
    {
        return $this->facebookId;
    }


    public static function signUpWithFacebook(
        UserId $id,
        FullName $fullName,
        UserFacebookId $facebookId,
        UserEmail $email,
        UserFacebookAccessToken $facebookAccessToken,
        UsersFollowed $usersFollowed

    ): self
    {
        $client = new self($id, $email, $fullName, null, $facebookId, $facebookAccessToken, $usersFollowed);

        $client->publish(
            new UserRegisteredWithFacebook(
                $client->id(),
                $fullName,
                $client->facebookId(),
                $client->facebookAccessToken(),
                $client->email()
            )
        );

        return $client;
    }

    public static function signUp(UserId $anId, UserEmail $anEmail, UserPassword $aPassword, array $userRoles)
    {

    }

    public function connectToFacebook(UserFacebookId $facebookId, UserFacebookAccessToken $accessToken): void
    {
        $this->facebookId = $facebookId;
        $this->lastLogin = new \DateTimeImmutable();
        $this->facebookAccessToken = $accessToken;

        $this->publish(
            new UserLoggedIn(
                $this->id,
                $this->email
            )
        );
    }

    public function updateUsersFollowed(UsersFollowed $usersFollowed) {
        $this->usersFollowed = $usersFollowed;
    }

    public static function availableRoles(): array
    {
        return [
            self::ROLE_CLIENT,
        ];
    }

    public function usersFollowed(): ?UsersFollowed
    {
        return $this->usersFollowed;
    }

    public function facebookAccessToken(): ?UserFacebookAccessToken
    {
        return $this->facebookAccessToken;
    }
}

