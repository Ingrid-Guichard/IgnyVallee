<?php

namespace App\Repository;

use App\Entity\SachetsGraines;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SachetsGraines|null find($id, $lockMode = null, $lockVersion = null)
 * @method SachetsGraines|null findOneBy(array $criteria, array $orderBy = null)
 * @method SachetsGraines[]    findAll()
 * @method SachetsGraines[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SachetsGrainesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SachetsGraines::class);
    }

    // /**
    //  * @return SachetsGraines[] Returns an array of SachetsGraines objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SachetsGraines
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
