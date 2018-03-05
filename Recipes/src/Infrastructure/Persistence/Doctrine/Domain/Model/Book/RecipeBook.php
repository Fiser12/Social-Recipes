<?php

namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book;

use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Recipes\Recipe;

class RecipeBook
{
    private $recipe;
    private $book;

    public function __construct(Recipe $recipe, Book $book)
    {
        $this->recipe = $recipe;
        $this->book = $book;
    }

    public function book(): Book
    {
        return $this->book;
    }

    public function recipe(): Recipe
    {
        return $this->recipe;
    }
}