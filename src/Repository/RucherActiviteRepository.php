<?php

namespace App\Repository;

use App\Entity\RucherActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RucherActivite|null find($id, $lockMode = null, $lockVersion = null)
 * @method RucherActivite|null findOneBy(array $criteria, array $orderBy = null)
 * @method RucherActivite[]    findAll()
 * @method RucherActivite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RucherActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RucherActivite::class);
    }

    // /**
    //  * @return RucherActivite[] Returns an array of RucherActivite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RucherActivite
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
