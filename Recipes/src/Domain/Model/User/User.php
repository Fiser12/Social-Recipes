<?php

namespace Recipes\Domain\Model\User;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Symfony\Component\Security\Core\User\UserInterface;

class User extends AggregateRoot implements UserInterface
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

    public function getRoles()
    {
    }

    public function getPassword()
    {
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
    }

    public function eraseCredentials()
    {

    }
}