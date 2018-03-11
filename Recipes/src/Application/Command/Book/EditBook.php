<?php

namespace Recipes\Application\Command\Book;

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use LIN3S\SharedKernel\Exception\Exception;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;
use Recipes\Domain\Model\Book\BookTranslation;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Subtitle;
use Recipes\Domain\Model\Title;
use Recipes\Domain\Model\Translation\TranslationCollection;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;

class EditBook
{
    private $repository;

    public function __construct(BookRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(EditBookCommand $command)
    {
        $book = $this->repository->bookOfId(BookId::generate($command->id()));

        if($book === null || !$book->owner()->equals(UserId::generate($command->userId()))) {
            throw new Exception('The book is of another user');
        }

        $translations = $this->translations($command->translations());

        $book->edit(
            UserId::generate($command->userId()),
            new Scope($command->scope()),
            $this->users($command->follow()),
            $this->recipes($command->recipeIds()),
            $translations
        );

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

    private function translations(array $translationsArray): TranslationCollection
    {
        $translations = new TranslationCollection();
        foreach ($translationsArray as $locale => $translationArray) {
            $translation = new BookTranslation(
                new Locale($locale),
                new Title($translationArray['title']),
                new Subtitle($translationArray['subtitle'])
            );
            $translations->add($translation);
        }
        return $translations;
    }

}