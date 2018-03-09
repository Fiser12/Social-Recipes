<?php

namespace Recipes\Application\Command\User;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use LIN3S\SharedKernel\Exception\Exception;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Category\CategoryId;
use Recipes\Domain\Model\Description;
use Recipes\Domain\Model\Difficulty;
use Recipes\Domain\Model\Recipes\HashtagCollection;
use Recipes\Domain\Model\Recipes\IngredientsCollection;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeRepository;
use Recipes\Domain\Model\Recipes\RecipeTranslation;
use Recipes\Domain\Model\Recipes\Servings;
use Recipes\Domain\Model\Recipes\Step;
use Recipes\Domain\Model\Recipes\StepId;
use Recipes\Domain\Model\Recipes\StepsCollection;
use Recipes\Domain\Model\Recipes\StepTranslation;
use Recipes\Domain\Model\Recipes\ToolsCollection;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Subtitle;
use Recipes\Domain\Model\Time;
use Recipes\Domain\Model\Title;
use Recipes\Domain\Model\Translation\TranslationCollection;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;
use Recipes\Domain\Model\User\UsersCollection;

class FollowBook
{
    private $bookRepository;
    private $userRepository;

    public function __construct(
        BookRepository $bookRepository,
        UserRepository $userRepository
    )
    {
        $this->bookRepository = $bookRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(FollowBookCommand $command)
    {
        $book = $this->bookRepository->bookOfId(BookId::generate($command->bookId()));

        $this->checkBookProperty($command->userId(), $book);

        $user = $this->userRepository->userOfId(UserId::generate($command->userId()));

        $friends = $this->userRepository->userOfId(UserId::generate($command->userId()))->friends();

        $this->checkIfBookIsFromAFriend($book, $friends);

        $user->followBook($book->id());
        $this->userRepository->persist($user);
    }

    private function checkBookProperty(string $userId, Book $book): void
    {
        if ($book->owner()->equals(UserId::generate($userId))
        ) {
            throw new Exception('The book if of the user');
        }
    }

    private function checkIfBookIsFromAFriend(Book $book, UsersCollection $friends): void
    {
        if (
            !$this->bookPropertyIsOfFriend($book, $friends)
            && !$book->scope()->equals(new Scope(Scope::PROTECTED)
            )
        ) {
            throw new Exception('The book is not of user friend and is protected');
        }
    }

    private function bookPropertyIsOfFriend(Book $book, UsersCollection $friends): bool
    {
        foreach ($friends as $friend) {
            if ($friend->equals($book->owner())) {
                return true;
            }
        }

        return false;
    }

}