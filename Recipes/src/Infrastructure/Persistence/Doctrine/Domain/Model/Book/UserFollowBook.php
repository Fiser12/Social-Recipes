<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book;

use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\User\User;

class UserFollowBook
{
    private $user;
    private $book;

    public function __construct(User $user, Book $book)
    {
        $this->user = $user;
        $this->book = $book;
    }

    public function book(): Book
    {
        return $this->book;
    }

    public function user(): User
    {
        return $this->user;
    }
}