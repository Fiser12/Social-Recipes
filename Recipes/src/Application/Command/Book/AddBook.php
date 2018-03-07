<?php

namespace Recipes\Application\Command\Book;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookTranslation;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Subtitle;
use Recipes\Domain\Model\Title;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;

class AddBook
{
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(AddBookCommand $command)
    {
        $book = new Book(
            BookId::generate($command->id()),
            UserId::generate($command->userId()),
            new Scope($command->scope()),
            $this->users($command->follow()),
            $this->recipes($command->recipeIds())
        );

        $this->translations($command->translations(), $book);

        $this->repository->persist($book);
    }

    private function recipes(array $recipeIds): RecipeCollection
    {
        $collection = new RecipeCollection();

        foreach($recipeIds as $id) {
            $collection->add(RecipeId::generate($id));
        }
        return $collection;
    }

    private function users(array $userIds): UsersCollection
    {
        $collection = new UsersCollection();

        foreach($userIds as $id) {
            $collection->add(UserId::generate($id));
        }
        return $collection;
    }

    private function translations(array $translationsArray, Book $book): void
    {
        foreach ($translationsArray as $locale => $translationArray) {
            $translation = new BookTranslation(
                new Locale($locale),
                new Title($translationArray['title']),
                new Subtitle($translationArray['subtitle'])
            );
            $book->addTranslation($translation);
        }
    }
}