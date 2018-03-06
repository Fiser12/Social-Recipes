<?php

namespace Recipes\Domain\Model\Book;

interface BookView
{
    public function list(array $criteria, int $limit = -1, int $offset = 0) : array;
}