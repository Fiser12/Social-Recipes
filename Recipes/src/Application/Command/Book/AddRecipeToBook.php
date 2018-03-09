<?php

namespace Recipes\Application\Command\Book;

use LIN3S\SharedKernel\Exception\Exception;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeRepository;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;
use Recipes\Domain\Model\User\UsersCollection;

class AddRecipeToBook
{
    private $bookRepository;
    private $recipeRepository;
    private $userRepository;

    public function __construct(
        BookRepository $bookRepository,
        RecipeRepository $recipeRepository,
        UserRepository $userRepository
    )
    {
        $this->bookRepository = $bookRepository;
        $this->recipeRepository = $recipeRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(AddRecipeToBookCommand $command)
    {
        $book = $this->bookRepository->bookOfId(BookId::generate($command->bookId()));

        $this->checkBookProperty($command, $book);

        $recipe = $this->recipeRepository->recipeOfId(RecipeId::generate($command->recipeId()));

        $this->checkRecipePropertyUserOwner($command, $recipe);

        $friends = $this->userRepository->userOfId(UserId::generate($command->userId()))->friends();

        $this->checkIfRecipeIsFromAFriend($recipe, $friends);

        $book->addRecipeToBook($recipe->id());

        $this->bookRepository->persist($book);
    }

    private function recipePropertyIsOfFriend(Recipe $recipe, UsersCollection $friends): bool
    {
        foreach ($friends as $friend) {
            if ($friend->equals($recipe->owner())) {
                return true;
            }
        }

        return false;
    }

    private function checkBookProperty(AddRecipeToBookCommand $command, Book $book): void
    {
        if (!$book->owner()->equals(UserId::generate($command->userId()))
        ) {
            throw new Exception('The book is of another user');
        }
    }

    private function checkRecipePropertyUserOwner(AddRecipeToBookCommand $command, Recipe $recipe): void
    {
        if (
            $recipe->scope()->equals(new Scope(Scope::PRIVATE))
            && !$recipe->owner()->equals(UserId::generate($command->userId())
            )
        ) {
            throw new Exception('The recipe is of another user and is private');
        }
    }

    private function checkIfRecipeIsFromAFriend(Recipe $recipe, UsersCollection $friends): void
    {
        if (
            !$this->recipePropertyIsOfFriend($recipe, $friends)
            && !$recipe->scope()->equals(new Scope(Scope::PROTECTED)
            )
        ) {
            throw new Exception('The recipe is not of user friend and is protected');
        }
    }

}