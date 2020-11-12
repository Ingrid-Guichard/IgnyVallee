<?php

namespace App\Repository;

use App\Entity\Parcelles;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Parcelles|null find($id, $lockMode = null, $lockVersion = null)
 * @method Parcelles|null findOneBy(array $criteria, array $orderBy = null)
 * @method Parcelles[]    findAll()
 * @method Parcelles[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParcellesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parcelles::class);
    }

    // /**
    //  * @return Parcelles[] Returns an array of Parcelles objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Parcelles
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
