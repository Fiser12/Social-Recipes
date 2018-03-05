<?php

namespace Recipes\Domain\Model\User;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends AggregateRoot
{
    protected $id;
    protected $email;
    protected $createBooks;
    protected $followBooks;
    protected $createRecipes;

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
        return new BooksCollection($this->createBooks->getValues());
    }

    public function followBooks(): BooksCollection
    {
        return new BooksCollection($this->followBooks->getValues());
    }

    public function createRecipes(): RecipeCollection
    {
        return new RecipeCollection($this->createRecipes->getValues());
    }
}