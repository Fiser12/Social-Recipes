<?php

namespace Recipes\Domain\Model\Book;

interface BookRepository
{
    public function bookOfId(BookId $bookId) : ?Book;

    public function persist(Book $book) : void;

    public function remove(BookId $bookId) : void;
}