<?php

namespace Recipes\Domain\Model\User;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;

class User implements AggregateRoot
{
    private $id;
    private $email;
    private $comments;

    use AggregateRootCapabilities;

    public function __construct(UserId $id, UserEmail $email, CommentsCollection $comments)
    {
        $this->id = $id;
        $this->email = $email;
        $this->comments = $comments;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function comments(): CommentsCollection
    {
        return $this->comments;
    }
}