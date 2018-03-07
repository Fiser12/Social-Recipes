<?php

namespace Recipes\Application\Command\Category;

use Recipes\Domain\Model\Category\CategoryId;
use Recipes\Domain\Model\Category\CategoryRepository;

class RemoveCategory
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RemoveRecipeCommand $command)
    {
        $this->repository->remove(CategoryId::generate($command->id()));
    }
}