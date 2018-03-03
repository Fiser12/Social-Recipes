<?php


namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Book;

use Doctrine\ORM\EntityRepository;
use Recipes\Domain\Model\Book\Book;
use Recipes\Domain\Model\Book\BookId;
use Recipes\Domain\Model\Book\BookRepository;

class DoctrineBookRepository extends EntityRepository implements BookRepository
{
    public function persist(Book $book): void
    {
        $this->getEntityManager()->persist($book);
        $this->getEntityManager()->flush();
    }

    public function remove(BookId $bookId): void
    {
        $book = $this->bookOfId($bookId);

        if ($book === null) {
            return;
        }

        $this->getEntityManager()->remove(
            $book
        );
    }

    public function bookOfId(BookId $bookId): ?Book
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('b')
            ->from('Book', 'b')
            ->where('b.id = :id')
            ->setParameter('id', $bookId->id())
            ->getQuery()
            ->getSingleResult();
    }
}
