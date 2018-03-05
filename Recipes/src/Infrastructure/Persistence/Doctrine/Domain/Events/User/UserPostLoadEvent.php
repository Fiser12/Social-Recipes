<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Events\User;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\User\User;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\UserFollowBook;

class UserPostLoadEvent
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof User) {
            return;
        }

        $this->loadFollowBooks($args, $entity);
        $this->loadCreateBooks($args, $entity);
        $this->loadCreateRecipes($args, $entity);
    }

    private function loadCreateRecipes(LifecycleEventArgs $args, $entity): void
    {
        $recipes = $args->getEntityManager()->getRepository(Recipe::class)->findBy(['owner' => $entity]);
        $recipeCollection = new RecipeCollection();
        foreach ($recipes as $recipe) {
            $recipeCollection->add($recipe->id());
        }
        $entityReflection = new \ReflectionClass($entity);
        $createRecipes = $entityReflection->getProperty('createRecipes');
        $createRecipes->setAccessible(true);
        $createRecipes->setValue($entity, $recipeCollection);
    }

    private function loadCreateBooks(LifecycleEventArgs $args, $entity): void
    {
        $books = $args->getEntityManager()->getRepository(Book::class)->findBy(['owner' => $entity]);
        $booksCollection = new BooksCollection();
        foreach ($books as $book) {
            $booksCollection->add($book->id());
        }
        $entityReflection = new \ReflectionClass($entity);
        $createBooks = $entityReflection->getProperty('createBooks');
        $createBooks->setAccessible(true);
        $createBooks->setValue($entity, $booksCollection);
    }

    private function loadFollowBooks(LifecycleEventArgs $args, $entity): void
    {
        $books = $args->getEntityManager()->getRepository(UserFollowBook::class)->findBy(['user' => $entity]);
        $booksCollection = new BooksCollection();
        foreach ($books as $book) {
            $booksCollection->add($book->book()->id());
        }
        $entityReflection = new \ReflectionClass($entity);
        $followBooks = $entityReflection->getProperty('followBooks');
        $followBooks->setAccessible(true);
        $followBooks->setValue($entity, $booksCollection);
    }
}
