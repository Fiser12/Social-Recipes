<?php

namespace Recipes\Domain\Model\User;

use LIN3S\SharedKernel\Domain\Model\AggregateRoot;
use Recipes\Domain\Model\Book\BookId;
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
    protected $friends;

    public function __construct(
        UserId $id,
        UserEmail $email,
        RecipeCollection $createRecipes,
        BooksCollection $createBooks,
        BooksCollection $followBooks,
        UsersCollection $friends
    )
    {
        $this->id = $id;
        $this->email = $email;
        $this->createBooks = $createBooks;
        $this->followBooks = $followBooks;
        $this->createRecipes = $createRecipes;
        $this->friends = $friends;
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

    public function followBook(BookId $bookId) : void
    {
        $this->followBooks->add($bookId);
    }

    public function unfollowBook(BookId $bookId) : void
    {
        $this->followBooks->remove($bookId);
    }

    public function friends(): UsersCollection
    {
        return $this->friends;
    }

}