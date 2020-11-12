<?php

namespace App\Repository;

use App\Entity\Filtres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Filtres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Filtres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Filtres[]    findAll()
 * @method Filtres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FiltresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Filtres::class);
    }

    // /**
    //  * @return Filtres[] Returns an array of Filtres objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Filtres
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
