<?php

namespace App\Repository;

use App\Entity\RecoltesMiel;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecoltesMiel|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecoltesMiel|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecoltesMiel[]    findAll()
 * @method RecoltesMiel[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecoltesMielRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecoltesMiel::class);
    }

    // /**
    //  * @return RecoltesMiel[] Returns an array of RecoltesMiel objects
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
    public function findOneBySomeField($value): ?RecoltesMiel
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
