<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Events\Book;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\User\User;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\RecipeBook;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\UserFollowBook;

class BookPostPersistEvent
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Book) {
            return;
        }

        $entityManager = $args->getEntityManager();

        //TODO Delete old
        foreach ($entity->recipes() as $recipeId) {
            $recipe = $entityManager->getReference(Recipe::class, $recipeId);
            $entityManager->persist(new RecipeBook($recipe, $entity));
        }

        //TODO Delete old
        foreach ($entity->follow() as $userId) {
            $user = $entityManager->getReference(User::class, $userId);
            $entityManager->persist(new UserFollowBook($user, $entity));
        }

        $entityManager->flush();
    }
}
