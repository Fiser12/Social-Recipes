<?php

namespace Recipes\Domain\Model\User;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Recipes\RecipeCollection;

class User extends AggregateRoot
{
    private $id;
    private $email;
    private $createBooks;
    private $followBooks;
    private $createRecipes;

    public function __construct(
        UserId $id,
        UserEmail $email,
        RecipeCollection $createRecipes,
        BooksCollection $createBooks,
        BooksCollection $followBooks
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->createBooks = $createBooks;
        $this->followBooks = $followBooks;
        $this->createRecipes = $createRecipes;
    }

    public function id(): UserId
    {
        return $this->id;
    }

    public function email(): UserEmail
    {
        return $this->email;
    }

    public function createBooks(): BooksCollection
    {
        return $this->createBooks;
    }

    public function followBooks(): BooksCollection
    {
        return $this->followBooks;
    }

    public function createRecipes(): RecipeCollection
    {
        return $this->createRecipes;
    }
}