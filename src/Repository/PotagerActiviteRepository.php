<?php

namespace App\Repository;

use App\Entity\PotagerActivite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PotagerActivite|null find($id, $lockMode = null, $lockVersion = null)
 * @method PotagerActivite|null findOneBy(array $criteria, array $orderBy = null)
 * @method PotagerActivite[]    findAll()
 * @method PotagerActivite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PotagerActiviteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PotagerActivite::class);
    }

    // /**
    //  * @return PotagerActivite[] Returns an array of PotagerActivite objects
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
    public function findOneBySomeField($value): ?PotagerActivite
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
