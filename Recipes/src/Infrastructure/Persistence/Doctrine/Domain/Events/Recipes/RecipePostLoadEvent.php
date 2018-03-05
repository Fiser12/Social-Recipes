<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Events\Recipes;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\RecipeBook;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Category\RecipeCategory;
use ReflectionClass;

class RecipePostLoadEvent
{
    public function postLoad(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof Recipe) {
            return;
        }

        $categories = $args->getEntityManager()->getRepository(RecipeCategory::class)->findBy(['recipe' => $entity]);
        $categoriesCollection = new CategoriesCollection();
        foreach($categories as $category) {
            $categoriesCollection->add($category->category()->id());
        }
        $entityReflection = new ReflectionClass($entity);
        $category = $entityReflection->getProperty('categories');
        $category->setAccessible(true);
        $category->setValue($entity, $categoriesCollection);

        $books = $args->getEntityManager()->getRepository(RecipeBook::class)->findBy(['recipe' => $entity]);
        $booksCollection = new BooksCollection();
        foreach($books as $book) {
            $booksCollection->add($book->book()->id());
        }
        $entityReflection = new ReflectionClass($entity);
        $book = $entityReflection->getProperty('books');
        $book->setAccessible(true);
        $book->setValue($entity, $booksCollection);

    }
}
