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

namespace Session\Application\Command\Session;

use Session\Domain\Model\Session\FirstName;
use Session\Domain\Model\Session\FullName;
use Session\Domain\Model\Session\LastName;
use Session\Domain\Model\Session\User;
use Session\Domain\Model\Session\UserFacebookAccessToken;
use Session\Domain\Model\Session\UserFacebookId;
use Session\Domain\Model\Session\UsersFollowed;
use BenGorUser\User\Domain\Model\UserEmail;
use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;

/**
 * @author José Elías Gutiérrez <jose@lin3s.com>
 * @author Ruben Garcia <ruben@lin3s.com>
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
        $user = $this->repository->userOfEmail(
            new UserEmail(
                $command->email()
            )
        );

        if (null === $user) {
            $user = User::signUpWithFacebook(
                new UserId($command->facebookId()),
                new FullName(
                    new FirstName($command->firstName()),
                    new LastName($command->lastName())
                ),
                new UserFacebookId($command->facebookId()),
                new UserEmail($command->email()),
                new UserFacebookAccessToken($command->facebookAccessToken()),
                $this->getUsersFollowed($command->usersFollowers())
            );
        }

        /** @var User $user */
        $user->connectToFacebook(
            new UserFacebookId($command->facebookId()),
            new UserFacebookAccessToken($command->facebookAccessToken()
            )
        );
        $user->updateUsersFollowed($this->getUsersFollowed($command->usersFollowers()));

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();
        } catch (ORMException $e) {
            return;
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

