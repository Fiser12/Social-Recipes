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

use BenGorUser\User\Domain\Model\Event\UserEvent;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use LIN3S\SharedKernel\Domain\Model\DomainEvent;

/**
 * @author Beñat Espiña <bespina@lin3s.com>
 */
class UserRegisteredWithFacebook implements UserEvent, DomainEvent
{
    private $userId;
    private $email;
    private $occurredOn;
    private $facebookId;
    private $facebookAccessToken;

    public function __construct(UserId $userId, UserFacebookId $facebookId, UserFacebookAccessToken $facebookAccessToken, UserEmail $email)
    {
        $this->occurredOn = new \DateTimeImmutable();
        $this->facebookId = $facebookId;
        $this->userId = $userId;
        $this->email = $email;
        $this->facebookAccessToken = $facebookAccessToken;
    }

    public function id() : UserId
    {
        return $this->userId;
    }

    public function facebookId() : UserFacebookId
    {
        return $this->facebookId;
    }

    public function email() : UserEmail
    {
        return $this->email;
    }

    public function occurredOn() : \DateTimeInterface
    {
        return $this->occurredOn;
    }

    public function facebookAccessToken(): UserFacebookAccessToken
    {
        return $this->facebookAccessToken;
    }
}
