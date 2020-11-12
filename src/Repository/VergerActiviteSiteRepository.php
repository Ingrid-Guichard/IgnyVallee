<?php

namespace App\Repository;

use App\Entity\VergerActiviteSite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method VergerActiviteSite|null find($id, $lockMode = null, $lockVersion = null)
 * @method VergerActiviteSite|null findOneBy(array $criteria, array $orderBy = null)
 * @method VergerActiviteSite[]    findAll()
 * @method VergerActiviteSite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VergerActiviteSiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VergerActiviteSite::class);
    }

    // /**
    //  * @return VergerActiviteSite[] Returns an array of VergerActiviteSite objects
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
    public function findOneBySomeField($value): ?VergerActiviteSite
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
