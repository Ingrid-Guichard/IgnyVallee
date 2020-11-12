<?php

namespace App\Repository;

use App\Entity\Sympathisants;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sympathisants|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sympathisants|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sympathisants[]    findAll()
 * @method Sympathisants[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SympathisantsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sympathisants::class);
    }

    // /**
    //  * @return Sympathisants[] Returns an array of Sympathisants objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Sympathisants
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
