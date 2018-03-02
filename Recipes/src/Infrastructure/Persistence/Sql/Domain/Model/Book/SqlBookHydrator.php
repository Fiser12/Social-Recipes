<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Book;

use Recipes\Domain\Model\Book\Book;
use Recipes\Infrastructure\Persistence\Hydrator;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlBookHydrator implements SqlHydrator
{
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function build(array $rows) : Book
    {
        return $this->hydrator->hydrate(
            $this->organizeRows($rows)
        );
    }

    private function organizeRows(array $rows) : array
    {

    }

}