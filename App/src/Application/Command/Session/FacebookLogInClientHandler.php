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

namespace App\Application\Command\Session;

use App\Domain\Model\Session\FirstName;
use App\Domain\Model\Session\FullName;
use App\Domain\Model\Session\LastName;
use App\Domain\Model\Session\User;
use App\Domain\Model\Session\UserFacebookAccessToken;
use App\Domain\Model\Session\UserFacebookId;
use App\Domain\Model\Session\UsersFollowed;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

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

    public function __invoke(FacebookLogInClientCommand $command): void
    {
        $email = new UserEmail($command->email());
        $user = $this->repository->userOfEmail($email);
        $facebookId = new UserFacebookId($command->facebookId());


        if (null === $user) {
            $user = User::signUpWithFacebook(
                new UserId($command->facebookId()),
                new FullName(new FirstName($command->firstName()), new LastName($command->lastName())),
                $facebookId,
                $email,
                new UserFacebookAccessToken($command->facebookAccessToken()),
                $this->getUsersFollowed($command->usersFollowers())
            );
        } else {
            /** @var User $user */
            $user->connectToFacebook($facebookId);
        }

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (ORMException $e) {
        }
    }

    private function getUsersFollowed(array $usersFollowed): UsersFollowed
    {
        $usersFollowedReturned = new UsersFollowed();
        foreach ($usersFollowed as $userFollowed) {
            $user = $this->repository->userOfId(new UserId($userFollowed));
            if ($user === null) {
                continue;
            }
            $usersFollowedReturned->add($user);
        }
        return $usersFollowedReturned;
    }
}

