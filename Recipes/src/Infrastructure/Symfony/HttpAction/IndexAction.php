<?php

/*
 * This file is part of the Php DDD Standard project.
 *
 * Copyright (c) 2017-present-present LIN3S <info@lin3s.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Recipes\Infrastructure\Symfony\HttpAction;

use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Category\CategoryId;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\DoctrineBookRepository;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Category\DoctrineCategoryRepository;
use Recipes\Infrastructure\Persistence\Sql\Domain\Model\Recipes\SqlRecipeRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexAction
{
    private $container;
    private $doctrineBookRepository;
    private $doctrineCategoryRepository;

    public function __construct(
        ContainerInterface $container,
        DoctrineBookRepository $doctrineBookRepository,
        DoctrineCategoryRepository $doctrineCategoryRepository
    )
    {
        $this->container = $container;
        $this->doctrineBookRepository = $doctrineBookRepository;
        $this->doctrineCategoryRepository = $doctrineCategoryRepository;
    }

    public function __invoke(Request $request)
    {

        $this->persistBook();
        $this->persistCategory();
        return new JsonResponse('Hello recipes');
    }
    private function persistBook(
        string $id = null,
        string $userId = "1",
        array $recipesArray = ["1" , "2"],
        array $followArray = ["1"]
    )
    {
        $follow = new UsersCollection();
        foreach($followArray as $f) {
            $follow->add(UserId::generate($f));
        }

        $recipes = new RecipeCollection();
        foreach($recipesArray as $recipe) {
            $recipes->add(RecipeId::generate($recipe));
        }

        $book = new Book(
            BookId::generate($id),
            UserId::generate($userId),
            new Scope("private"),
            $follow,
            $recipes
        );
        $this->doctrineBookRepository->persist($book);
    }

    private function persistCategory(
        string $id = null,
        array $recipesArray = ["1" , "2"]
    ) {
        $recipes = new RecipeCollection();
        foreach($recipesArray as $recipe) {
            $recipes->add(RecipeId::generate($recipe));
        }
        $category = new Category(
            CategoryId::generate($id),
            $recipes,
            null,
            new CategoriesCollection()
        );
        $this->doctrineCategoryRepository->persist($category);
    }
}
