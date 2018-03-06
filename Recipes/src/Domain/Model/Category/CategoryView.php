<?php

namespace Recipes\Domain\Model\Category;

interface CategoryView
{
    public function list(array $criteria, int $limit = -1, int $offset = 0) : array;
}