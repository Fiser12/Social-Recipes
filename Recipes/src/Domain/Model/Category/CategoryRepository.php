<?php

namespace Recipes\Domain\Model\Category;

interface CategoryRepository
{
    public function categoryOfId(CategoryId $categoryId) : ?Category;

    public function persist(Category $category) : void;

    public function remove(CategoryId $categoryId) : void;
}