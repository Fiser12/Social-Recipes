<?php

namespace Recipes\Infrastructure\Persistence\Sql\Domain\Model\User;

use Recipes\Domain\Model\User\User;
use Recipes\Infrastructure\Persistence\Hydrator;
use Recipes\Infrastructure\Persistence\Sql\SqlHydrator;

class SqlUserHydrator implements SqlHydrator
{
    private $hydrator;

    public function __construct(Hydrator $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    public function build(array $rows) : User
    {
        return $this->hydrator->hydrate(
            $this->organizeRows($rows)
        );
    }

    private function organizeRows(array $rows) : array
    {

    }

}