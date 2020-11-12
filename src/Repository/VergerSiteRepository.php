<?php

namespace App\Repository;

use App\Entity\VergerSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VergerSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method VergerSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method VergerSite[]    findAll()
 * @method VergerSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VergerSiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VergerSite::class);
    }

    // /**
    //  * @return VergerSite[] Returns an array of VergerSite objects
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
    public function findOneBySomeField($value): ?VergerSite
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
