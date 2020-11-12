<?php

namespace App\Repository;

use App\Entity\VergerActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VergerActivite|null find($id, $lockMode = null, $lockVersion = null)
 * @method VergerActivite|null findOneBy(array $criteria, array $orderBy = null)
 * @method VergerActivite[]    findAll()
 * @method VergerActivite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VergerActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VergerActivite::class);
    }

    // /**
    //  * @return VergerActivite[] Returns an array of VergerActivite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?VergerActivite
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
