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

use BenGorUser\User\Domain\Model\User as BaseUser;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;

class User extends BaseUser
{
    private $facebookId;
    private $facebookAccessToken;
    private $usersFollowed;
    private $usersFollowMe;

    public function __construct(
        UserId $anId,
        UserEmail $anEmail,
        UserFacebookId $facebookId,
        UserFacebookAccessToken $facebookAccessToken,
        UsersFollowed $usersFollowed,
        UsersFollowMe $usersFollowMe,
        array $userRoles
    )
    {
        parent::__construct($anId, $anEmail, $userRoles, null);
        $this->facebookId = $facebookId;
        $this->facebookAccessToken = $facebookAccessToken;
        $this->usersFollowed = $usersFollowed;
        $this->usersFollowMe = $usersFollowMe;
    }

    public function facebookId() : UserFacebookId{
        return $this->facebookId;
    }

    public function facebookAccessToken() : UserFacebookAccessToken{
        return $this->facebookAccessToken;
    }

    public function usersFollowed() : UsersFollowed
    {
        return $this->usersFollowed;
    }

    public function usersFollowMe() : UsersFollowMe
    {
        return $this->usersFollowMe;
    }
}
