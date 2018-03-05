<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Events\Book;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\User\UsersCollection;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\RecipeBook;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\UserFollowBook;

class BookPostLoadEvent
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Book) {
            return;
        }

        $users = $args->getEntityManager()->getRepository(UserFollowBook::class)->findBy(['book' => $entity]);

        $usersFollowBook = new UsersCollection();
        foreach($users as $user) {
            $usersFollowBook->add($user->user()->id());
        }
        $entityReflection = new \ReflectionClass($entity);
        $owner = $entityReflection->getProperty('follow');
        $owner->setAccessible(true);
        $owner->setValue($entity, $usersFollowBook);


        $recipes = $args->getEntityManager()->getRepository(RecipeBook::class)->findBy(['book' => $entity]);

        $recipeCollection = new RecipeCollection();
        foreach($recipes as $recipe) {
            $recipeCollection->add($recipe->recipe()->id());
        }
        $entityReflection = new \ReflectionClass($entity);
        $owner = $entityReflection->getProperty('recipes');
        $owner->setAccessible(true);
        $owner->setValue($entity, $recipeCollection);

    }
}
