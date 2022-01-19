<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * @return Users[] Returns an array of Users objects
     */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.email like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('u.action', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function sortByActionUp()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.action', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function sortByActionDown()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.action', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Users
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
