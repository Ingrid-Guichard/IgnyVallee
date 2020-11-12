<?php

namespace App\Repository;

use App\Entity\Ruches;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ruches|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ruches|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ruches[]    findAll()
 * @method Ruches[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RuchesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ruches::class);
    }

    // /**
    //  * @return Ruches[] Returns an array of Ruches objects
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
    public function findOneBySomeField($value): ?Ruches
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByNom($nom)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.nomRuche LIKE :nom')
            ->setParameter('nom', $nom.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByRucher($rucher)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.rucher = :rucher')
            ->setParameter('rucher', $rucher)
            ->getQuery()
            ->getResult()
            ;
    }
}
