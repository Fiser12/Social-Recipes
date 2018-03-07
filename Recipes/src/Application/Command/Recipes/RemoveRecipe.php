<?php

namespace Recipes\Application\Command\Recipes;

use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeRepository;

class RemoveRecipe
{
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RemoveRecipeCommand $command)
    {
        $this->repository->remove(RecipeId::generate($command->id()));
    }
}