<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\Recipes;

use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Infrastructure\Persistence\Hydrator;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlRecipeHydrator implements SqlHydrator
{
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function build(array $rows) : Recipe
    {
        return $this->hydrator->hydrate(
            $this->organizeRows($rows)
        );
    }

    private function organizeRows(array $rows) : array
    {

    }

}