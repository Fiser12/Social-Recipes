<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Events\Book;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Query\ResultSetMapping;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\User\User;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\RecipeBook;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\UserFollowBook;

class BookPostUpdateEvent
{
    public function preUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Book) {
            return;
        }
        $entityManager = $args->getEntityManager();

        $this->deleteOld($entityManager, $entity, RecipeBook::class, 'book');
        $this->deleteOld($entityManager, $entity, UserFollowBook::class, 'book');
        $entityManager->flush();
        die;
        foreach ($entity->recipes() as $recipeId) {
            $recipe = $entityManager->getReference(Recipe::class, $recipeId);
            $entityManager->persist(new RecipeBook($recipe, $entity));
        }

        foreach ($entity->follow() as $userId) {
            $user = $entityManager->getReference(User::class, $userId);
            $entityManager->persist(new UserFollowBook($user, $entity));
        }

        $entityManager->flush();
    }

    private function deleteOld(EntityManager $entityManager, Book $book, string $class, string $attribute)
    {
        $qb = $entityManager->createQueryBuilder();
        $qb->delete($class, 'c');
        $qb->where('c.$attribute = :$attribute');
        $qb->setParameter('book', $book);
    }

}
