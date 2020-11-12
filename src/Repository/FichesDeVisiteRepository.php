<?php

namespace App\Repository;

use App\Entity\FichesDeVisite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FichesDeVisite|null find($id, $lockMode = null, $lockVersion = null)
 * @method FichesDeVisite|null findOneBy(array $criteria, array $orderBy = null)
 * @method FichesDeVisite[]    findAll()
 * @method FichesDeVisite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FichesDeVisiteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FichesDeVisite::class);
    }

    // /**
    //  * @return FichesDeVisite[] Returns an array of FichesDeVisite objects
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
    public function findOneBySomeField($value): ?FichesDeVisite
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
