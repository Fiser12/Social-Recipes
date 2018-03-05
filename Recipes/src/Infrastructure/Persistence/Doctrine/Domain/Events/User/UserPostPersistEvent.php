<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Events\User;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\User\User;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\UserFollowBook;

class UserPostPersistEvent
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof User) {
            return;
        }

        $entityManager = $args->getEntityManager();

        //TODO Delete old
        foreach ($entity->createRecipes() as $recipeId) {
            $recipe = $entityManager->getRepository(Recipe::class)->recipeOfId($recipeId);
            $recipeReflection = new \ReflectionClass($recipe);
            $owner = $recipeReflection->getProperty('owner');
            $owner->setAccessible(true);
            $owner->setValue($recipe, $entity);
            $entityManager->persist($recipe);
        }

        //TODO Delete old
        foreach ($entity->createBooks() as $bookId) {
            $book = $entityManager->getRepository(Book::class)->bookOfId($bookId);
            $bookReflection = new \ReflectionClass($book);
            $owner = $bookReflection->getProperty('owner');
            $owner->setAccessible(true);
            $owner->setValue($book, $entity);
            $entityManager->persist($book);
        }

        foreach ($entity->followBooks() as $bookId) {
            $book = $entityManager->getReference(Book::class, $bookId);
            $entityManager->persist(new UserFollowBook($entity, $book));
        }

        $entityManager->flush();
    }
}
