<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Events\Category;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Category\RecipeCategory;

class CategoryPostLoadEvent
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Category) {
            return;
        }

        $recipes = $args->getEntityManager()->getRepository(RecipeCategory::class)->findBy(['category' => $entity]);
        $recipesCollection = new RecipeCollection();
        foreach($recipes as $recipe) {
            $recipesCollection->add($recipe->recipe()->id());
        }
        $entityReflection = new \ReflectionClass($entity);
        $children = $entityReflection->getProperty('recipes');
        $children->setAccessible(true);
        $children->setValue($entity, $recipesCollection);
    }
}
