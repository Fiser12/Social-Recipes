<?php

namespace Recipes\Application\Command\Book;

use LIN3S\SharedKernel\Exception\Exception;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeRepository;
use Recipes\Domain\Model\User\UserId;

class RemoveRecipeToBook
{
    private $bookRepository;
    private $recipeRepository;

    public function __construct(
        BookRepository $bookRepository,
        RecipeRepository $recipeRepository
    )
    {
        $this->bookRepository = $bookRepository;
        $this->recipeRepository = $recipeRepository;
    }

    public function __invoke(AddRecipeToBookCommand $command)
    {
        $book = $this->bookRepository->bookOfId(BookId::generate($command->bookId()));

        $this->checkBookProperty($command, $book);

        $recipe = $this->recipeRepository->recipeOfId(RecipeId::generate($command->recipeId()));

        $book->removeRecipeFromBook($recipe->id());

        $this->bookRepository->persist($book);
    }

    private function checkBookProperty(AddRecipeToBookCommand $command, Book $book): void
    {
        if (!$book->owner()->equals(UserId::generate($command->userId()))
        ) {
            throw new Exception('The book is of another user');
        }
    }
}