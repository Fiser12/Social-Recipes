<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Events\Category;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Category\RecipeCategory;

class CategoryPostPersistEvent
{
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if (!$entity instanceof Category) {
            return;
        }

        $entityManager = $args->getEntityManager();

        //TODO Delete old
        foreach ($entity->recipes() as $recipeId) {
            $recipe = $entityManager->getReference(Recipe::class, $recipeId);
            $entityManager->persist(new RecipeCategory($recipe, $entity));
        }

        $entityManager->flush();
    }
}
