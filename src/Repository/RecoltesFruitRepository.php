<?php

namespace App\Repository;

use App\Entity\RecoltesFruit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecoltesFruit|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecoltesFruit|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecoltesFruit[]    findAll()
 * @method RecoltesFruit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecoltesFruitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecoltesFruit::class);
    }

    // /**
    //  * @return RecoltesFruit[] Returns an array of RecoltesFruit objects
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
    public function findOneBySomeField($value): ?RecoltesFruit
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
