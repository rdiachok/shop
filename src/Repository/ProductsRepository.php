<?php

namespace App\Repository;

use App\Entity\Products;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Products|null find($id, $lockMode = null, $lockVersion = null)
 * @method Products|null findOneBy(array $criteria, array $orderBy = null)
 * @method Products[]    findAll()
 * @method Products[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Products::class);
    }

    /**
     * @return Products[] Returns an array of Products objects
     */

    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name like :val')
            ->setParameter('val', '%' . $value . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldNameAsc($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.name', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldNameDesc($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.name', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldMakerAsc($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.maker', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldMakerDesc($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.maker', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldPriceAsc($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.price', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldPriceDesc($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.name like :val')
            ->setParameter('val', '%' . $value . '%')
            ->orderBy('p.price', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldAllNameAsc()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldAllNameDesc()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.name', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldAllMakerAsc()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.maker', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldAllMakerDesc()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.maker', 'DESC')
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldAllPriceAsc()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.price', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByExampleFieldAllPriceDesc()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.price', 'DESC')
            ->getQuery()
            ->getResult();
    }

    /*
    public function findOneBySomeField($value): ?Products
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
