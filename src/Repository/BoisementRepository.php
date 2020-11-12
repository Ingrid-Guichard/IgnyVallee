<?php

namespace App\Repository;

use App\Entity\Boisement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Boisement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Boisement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Boisement[]    findAll()
 * @method Boisement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BoisementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Boisement::class);
    }

    // /**
    //  * @return Boisement[] Returns an array of Boisement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Boisement
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
