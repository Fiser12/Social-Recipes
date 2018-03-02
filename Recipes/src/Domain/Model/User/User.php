<?php

namespace Recipes\Domain\Model\User;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use LIN3S\SharedKernel\Domain\Model\AggregateRootCapabilities;
use Recipes\Domain\Model\Book\BooksCollection;

class User implements AggregateRoot
{
    private $id;
    private $email;
    private $comments;
    private $createBooks;
    private $followBooks;

    use AggregateRootCapabilities;

    public function __construct(
        UserId $id,
        UserEmail $email,
        CommentsCollection $comments,
        BooksCollection $createBooks,
        BooksCollection $followBooks
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->comments = $comments;
        $this->createBooks = $createBooks;
        $this->followBooks = $followBooks;
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

    public function createBooks(): BooksCollection
    {
        return $this->createBooks;
    }

    public function followBooks(): BooksCollection
    {
        return $this->followBooks;
    }
}