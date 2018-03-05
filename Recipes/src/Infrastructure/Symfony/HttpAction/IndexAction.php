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

use LIN3S\SharedKernel\Domain\Model\Locale\Locale;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BooksCollection;
use Recipes\Domain\Model\Book\BookTranslation;
use Recipes\Domain\Model\Category\CategoriesCollection;
use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Category\CategoryId;
use Recipes\Domain\Model\Category\CategoryTranslation;
use Recipes\Domain\Model\Description;
use Recipes\Domain\Model\Difficulty;
use Recipes\Domain\Model\Name;
use Recipes\Domain\Model\Quantity;
use Recipes\Domain\Model\Recipes\Hashtag;
use Recipes\Domain\Model\Recipes\HashtagCollection;
use Recipes\Domain\Model\Recipes\Ingredient;
use Recipes\Domain\Model\Recipes\IngredientsCollection;
use Recipes\Domain\Model\Recipes\IngredientTranslation;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\Recipes\RecipeCollection;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeTranslation;
use Recipes\Domain\Model\Recipes\Servings;
use Recipes\Domain\Model\Recipes\Step;
use Recipes\Domain\Model\Recipes\StepId;
use Recipes\Domain\Model\Recipes\StepsCollection;
use Recipes\Domain\Model\Recipes\StepTranslation;
use Recipes\Domain\Model\Recipes\Tool;
use Recipes\Domain\Model\Recipes\ToolsCollection;
use Recipes\Domain\Model\Recipes\ToolTranslation;
use Recipes\Domain\Model\Scope;
use Recipes\Domain\Model\Subtitle;
use Recipes\Domain\Model\Time;
use Recipes\Domain\Model\Title;
use Recipes\Domain\Model\User\User;
use Recipes\Domain\Model\User\UserEmail;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UsersCollection;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book\DoctrineBookRepository;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Category\DoctrineCategoryRepository;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Recipes\DoctrineRecipeRepository;
use Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\User\DoctrineUserRepository;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class IndexAction
{
    private $container;
    private $doctrineBookRepository;
    private $doctrineCategoryRepository;
    private $doctrineUserRepository;
    private $doctrineRecipeRepository;

    public function __construct(
        ContainerInterface $container,
        DoctrineBookRepository $doctrineBookRepository,
        DoctrineCategoryRepository $doctrineCategoryRepository,
        DoctrineUserRepository $doctrineUserRepository,
        DoctrineRecipeRepository $doctrineRecipeRepository
    )
    {
        $this->container = $container;
        $this->doctrineBookRepository = $doctrineBookRepository;
        $this->doctrineCategoryRepository = $doctrineCategoryRepository;
        $this->doctrineUserRepository = $doctrineUserRepository;
        $this->doctrineRecipeRepository = $doctrineRecipeRepository;
    }

    public function __invoke(Request $request)
    {
        dump($this->doctrineUserRepository->userOfId(UserId::generate("1")));die;
        //$this->persistRecipe("recipe2");
        //dump($this->doctrineRecipeRepository->recipeOfId(RecipeId::generate("1")));die;
        //dump($this->doctrineCategoryRepository->categoryOfId(CategoryId::generate("2")));die;
        //$this->persistBook("book2");
        //dump($this->doctrineBookRepository->bookOfId(BookId::generate("book2")));die;
        //$this->persistCategory("3");
        //dump($this->doctrineCategoryRepository->categoryOfId(CategoryId::generate("3")));die;
        //TODO Terminar los load de Recipe y User
        //TODO Arreglar el problema de los steps
        return new JsonResponse('Hello recipes');
    }

    private function persistUser(
        string $id = null,
        array $recipesArray = ["1", "2"],
        array $followArray = ["1", "2", "3"],
        array $createArray = ["4", "5"]
    )
    {
        $follow = new BooksCollection();
        foreach ($followArray as $f) {
            $follow->add(BookId::generate($f));
        }

        $create = new BooksCollection();
        foreach ($createArray as $c) {
            $create->add(BookId::generate($c));
        }

        $recipes = new RecipeCollection();
        foreach ($recipesArray as $recipe) {
            $recipes->add(RecipeId::generate($recipe));
        }

        $user = new User(
            UserId::generate($id),
            new UserEmail('mail@gmail.com'),
            $recipes,
            $create,
            $follow
        );
        $this->doctrineUserRepository->persist($user);
    }


    private function persistBook(
        string $id = null,
        string $userId = "1",
        array $recipesArray = ["recipe1", "recipe2"],
        array $followArray = ["1"]
    )
    {
        $follow = new UsersCollection();
        foreach ($followArray as $f) {
            $follow->add(UserId::generate($f));
        }

        $recipes = new RecipeCollection();
        foreach ($recipesArray as $recipe) {
            $recipes->add(RecipeId::generate($recipe));
        }

        $book = new Book(
            BookId::generate($id),
            UserId::generate($userId),
            new Scope("private"),
            $follow,
            $recipes
        );
        $book->addTranslation(new BookTranslation(
           new Locale("es"),
           new Title("title"),
           new Subtitle("subtitle")
        ));
        $this->doctrineBookRepository->persist($book);
    }

    private function persistCategory(
        string $id = null,
        array $recipesArray = ["1"]
    )
    {
        $recipes = new RecipeCollection();
        foreach ($recipesArray as $recipe) {
            $recipes->add(RecipeId::generate($recipe));
        }
        $category = new Category(
            CategoryId::generate($id),
            $recipes
        );
        $category->addTranslation(new CategoryTranslation(
           new Locale("es"),
           new Name("name")
        ));
        $this->doctrineCategoryRepository->persist($category);
    }

    private function persistRecipe(
        string $id = null,
        string $userId = "1",
        array $categories = ["1", "2"],
        array $book = ["1", "2"]
    )
    {
        $stepCollection = new StepsCollection();
        $hashTagCollection = new HashtagCollection();
        $ingredientsCollection = new IngredientsCollection();
        $toolsCollection = new ToolsCollection();
        $categoriesCollection = new CategoriesCollection();
        foreach ($categories as $c) {
            $categoriesCollection->add(CategoryId::generate($c));
        }

        $bookCollection = new BooksCollection();
        foreach ($book as $b) {
            $bookCollection->add(BookId::generate($b));
        }

        $ingredientsCollection->add($this->generateIngredient($ingredientsCollection));
        $toolsCollection->add($this->generateTool());
        $hashTagCollection->add($this->generateHashTag());

        $recipe = new Recipe(
            RecipeId::generate($id),
            $stepCollection,
            $hashTagCollection,
            $ingredientsCollection,
            $toolsCollection,
            $categoriesCollection,
            new Servings(2),
            new Time(2),
            new Difficulty(Difficulty::HARD),
            new Scope(Scope::PRIVATE),
            UserId::generate($userId),
            $bookCollection
        );
        $stepCollection->add($this->generateStep($recipe));
        $stepCollection->add($this->generateStep($recipe));
        $recipe->addTranslation(
            new RecipeTranslation(
                new Locale('es'),
                new Title('title'),
                new Subtitle('subtitle'),
                new Description('descrition')
            )
        );
        $this->doctrineRecipeRepository->persist($recipe);
    }

    private function generateStep(Recipe $recipe)
    {
        $ingredientsCollection = new IngredientsCollection();
        $ingredientsCollection->add($this->generateIngredient($ingredientsCollection));
        $toolsCollection = new ToolsCollection();
        $toolsCollection->add($this->generateTool());
        $step = new Step(
            StepId::generate(),
            $ingredientsCollection,
            $toolsCollection,
            $recipe
        );

        $step->addTranslation(
            new StepTranslation(
                new Locale('es'),
                new Description("esss")
            )
        );
        $step->addTranslation(
            new StepTranslation(
                new Locale('en'),
                new Description("esss2")
            )
        );

        return $step;
    }

    private function generateIngredient(): Ingredient
    {
        $ingredient = new Ingredient(new Quantity(3.4));
        $ingredient->addTranslation(
            new IngredientTranslation(
                new Locale('es'),
                new Name("esss")
            )
        );
        $ingredient->addTranslation(
            new IngredientTranslation(
                new Locale('en'),
                new Name("esss2")
            )
        );

        return $ingredient;
    }

    private function generateTool(): Tool
    {
        $tool = new Tool();
        $tool->addTranslation(
            new ToolTranslation(
                new Locale('es'),
                new Name("esss")
            )
        );
        $tool->addTranslation(
            new ToolTranslation(
                new Locale('en'),
                new Name("esss2")
            )
        );
        return $tool;
    }

    private function generateHashTag(): Hashtag
    {
        return new Hashtag("hutler");
    }
}
