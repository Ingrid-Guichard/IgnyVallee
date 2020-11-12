<?php

namespace App\Repository;

use App\Entity\Emprunts;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Emprunts|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunts|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunts[]    findAll()
 * @method Emprunts[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmpruntsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunts::class);
    }

    // /**
    //  * @return Emprunts[] Returns an array of Emprunts objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Emprunts
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
