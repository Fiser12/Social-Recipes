<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Events\Recipes;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\RecipeBook;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Category\RecipeCategory;

class RecipePostPersistEvent
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Recipe) {
            return;
        }

        $entityManager = $args->getEntityManager();

        //TODO Delete old
        foreach ($entity->books() as $bookId) {
            $book = $entityManager->getReference(Book::class, $bookId);
            $entityManager->persist(new RecipeBook($entity, $book));
        }

        //TODO Delete old
        foreach ($entity->categories() as $categoryId) {
            $category = $entityManager->getReference(Category::class, $categoryId);
            $entityManager->persist(new RecipeCategory($entity, $category));
        }

        $entityManager->flush();
    }
}
