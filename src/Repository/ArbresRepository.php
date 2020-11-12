<?php

namespace App\Repository;

use App\Entity\Arbres;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Arbres|null find($id, $lockMode = null, $lockVersion = null)
 * @method Arbres|null findOneBy(array $criteria, array $orderBy = null)
 * @method Arbres[]    findAll()
 * @method Arbres[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArbresRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Arbres::class);
    }

    // /**
    //  * @return Arbres[] Returns an array of Arbres objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Arbres
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByParrainageValide()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.parrainageValide = false')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findBynumeroArbre($num)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.numeroArbre LIKE :num')
            ->setParameter('num', $num.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherent($adherent)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.adherent = :adherent')
            ->setParameter('adherent', $adherent)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getBynumeroArbreByAdherent($num, $adherent)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.numeroArbre LIKE :num AND a.adherent = :adherent')
            ->setParameter('num', $num.'%')
            ->setParameter('adherent', $adherent)
            ->getQuery()
            ->getResult()
            ;
    }
}
