<?php

namespace Recipes\Domain\Model\Recipes;

interface RecipeView
{
    public function list(array $criteria, int $limit = -1, int $offset = 0) : array;
}