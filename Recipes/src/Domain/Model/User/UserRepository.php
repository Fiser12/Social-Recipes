<?php

namespace Recipes\Domain\Model\User;

interface UserRepository
{
    public function userOfId(UserId $userId) : ?User;

    public function persist(User $user) : void;

    public function remove(User $user) : void;
}