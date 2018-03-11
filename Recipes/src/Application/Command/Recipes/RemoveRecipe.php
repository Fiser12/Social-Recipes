<?php

namespace Recipes\Application\Command\Recipes;

use LIN3S\SharedKernel\Exception\Exception;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeRepository;
use Recipes\Domain\Model\User\UserId;

class RemoveRecipe
{
    private $repository;

    public function __construct(RecipeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(RemoveRecipeCommand $command)
    {
        $recipe = $this->repository->recipeOfId(RecipeId::generate($command->id()));

        if($recipe === null || !$recipe->owner()->equals(UserId::generate($command->userId()))) {
            throw new Exception('Invalid userId, is not your book');
        }

        $this->repository->remove(RecipeId::generate($command->id()));
    }
}