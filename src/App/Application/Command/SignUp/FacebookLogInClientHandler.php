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

use App\Domain\Model\User\User;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserRepository;

/**
 * @author José Elías Gutiérrez <jose@lin3s.com>
 */
class FacebookLogInClientHandler
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(FacebookLogInClientCommand $command) : void
    {
        $facebookId = $command->facebookId();
        $email = new UserEmail($command->email());
        $user = $this->repository->userOfEmail($email);

        if (null === $user) {
            $user = User::signUpWithFacebook(
                new UserId(),
                $facebookId,
                $email
            );
        } else {
            $user->connectToFacebook($facebookId);
        }
        $this->repository->persist($user);
    }
}
