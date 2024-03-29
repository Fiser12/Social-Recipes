<?php


namespace Recipes\Infrastructure\Persistence\Doctrine\Domain\Model\User;

use Doctrine\ORM\EntityRepository;
use Recipes\Domain\Model\User\User;
use Recipes\Domain\Model\User\UserId;
use Recipes\Domain\Model\User\UserRepository;

class DoctrineUserRepository extends EntityRepository implements UserRepository
{
    public function persist(User $user) : void
    {
        $this->getEntityManager()->getUnitOfWork()->scheduleForUpdate($user);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    public function remove(UserId $userId) : void
    {
        $user = $this->userOfId($userId);

        if($user === null) {
            return;
        }

        $this->getEntityManager()->remove(
            $user
        );
    }

    public function userOfId(UserId $userId) : ?User
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder();
        return $queryBuilder
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.id = :id')
            ->setParameter('id', $userId->id())
            ->getQuery()
            ->getOneOrNullResult();
    }
}
