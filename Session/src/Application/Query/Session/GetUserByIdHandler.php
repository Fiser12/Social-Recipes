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

namespace Session\Application\Query\Session;

use BenGorUser\User\Domain\Model\UserId;
use BenGorUser\User\Domain\Model\UserRepository;
use Session\Domain\Model\Session\User;

/**
 * @author Ruben Garcia <ruben@lin3s.com>
 */
class GetUserByIdHandler
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(GetUserByIdQuery $command): array
    {
        $user = $this->userRepository->userOfId(new UserId($command->id()));

        $friends = [];
        foreach($user->usersFollowed() as $friend) {
            $friends[] = $friend->id()->id();
        }

        $roles = [];
        foreach($user->roles() as $role) {
            $roles[] = $role->role();
        }

        return [
            'id' => $user->id()->id(),
            'email' => $user->email()->email(),
            'friends' => $friends,
            'roles' => $roles
        ];
    }
}

