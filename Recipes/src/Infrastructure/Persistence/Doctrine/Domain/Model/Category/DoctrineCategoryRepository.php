<?php


namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\Category;

use Doctrine\ORM\EntityRepository;
use Recipes\Domain\Model\Category\Category;
use Recipes\Domain\Model\Category\CategoryId;
use Recipes\Domain\Model\Category\CategoryRepository;

class DoctrineCategoryRepository extends EntityRepository implements CategoryRepository
{
    public function persist(Category $category) : void
    {
        $this->getEntityManager()->getUnitOfWork()->scheduleForUpdate($category);
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }

    public function remove(CategoryId $categoryId) : void
    {
        $category = $this->categoryOfId($categoryId);

        if($category === null) {
            return;
        }

        $this->getEntityManager()->remove(
            $category
        );
    }

    public function categoryOfId(CategoryId $categoryId) : ?Category
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('c')
            ->from(Category::class, 'c')
            ->where('c.id = :id')
            ->setParameter('id', $categoryId->id())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
