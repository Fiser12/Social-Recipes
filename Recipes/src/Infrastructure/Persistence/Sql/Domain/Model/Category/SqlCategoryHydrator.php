<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Category;

use Recipes\Domain\Model\Category\Category;
use Recipes\Infrastructure\Persistence\Hydrator;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlCategoryHydrator implements SqlHydrator
{
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function build(array $rows) : Category
    {
        return $this->hydrator->hydrate(
            $this->organizeRows($rows)
        );
    }

    private function organizeRows(array $rows) : array
    {

    }

}