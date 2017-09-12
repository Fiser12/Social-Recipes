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

use BenGorUser\User\Domain\Model\User as BaseUser;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;

class User extends BaseUser
{
    private $facebookId;
    private $facebookAccessToken;

    public function __construct(UserId $anId, UserEmail $anEmail, UserFacebookId $facebookId, UserFacebookAccessToken $facebookAccessToken, array $userRoles, $aPassword = null)
    {
        parent::__construct($anId, $anEmail, $userRoles, $aPassword);
        $this->facebookId = $facebookId;
        $this->facebookAccessToken = $facebookAccessToken;
    }

    public function facebookId(){
        return $this->facebookId;
    }

    public function facebookAccessToken(){
        return $this->facebookAccessToken;
    }
}
