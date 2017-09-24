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
use Doctrine\ORM\EntityManager;

/**
 * @author José Elías Gutiérrez <jose@lin3s.com>
 */
class FacebookLogInClientHandler
{
    private $repository;
    private $entityManager;

    public function __construct(UserRepository $repository, EntityManager $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
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
            /** @var User $user */
            $user->connectToFacebook($facebookId);
        }
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}
