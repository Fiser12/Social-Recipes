<?php


namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Recipes;

use Doctrine\ORM\EntityRepository;
use Recipes\Domain\Model\Recipes\Recipe;
use Recipes\Domain\Model\Recipes\RecipeId;
use Recipes\Domain\Model\Recipes\RecipeRepository;

class DoctrineRecipeRepository extends EntityRepository implements RecipeRepository
{
    public function persist(Recipe $recipe) : void
    {
        $this->getEntityManager()->persist($recipe);
    }

    public function remove(RecipeId $recipeId) : void
    {
        $recipe = $this->recipeOfId($recipeId);

        if($recipe === null) {
            return;
        }

        $this->getEntityManager()->remove(
            $recipe
        );
    }

    public function recipeOfId(RecipeId $recipeId) : ?Recipe
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('r')
            ->from('Recipe', 'r')
            ->where('r.id = :id')
            ->setParameter('id', $recipeId->id())
            ->getQuery()
            ->getSingleResult();
    }
}
