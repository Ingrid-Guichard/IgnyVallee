<?php

namespace App\Repository;

use App\Entity\Ateliers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ateliers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ateliers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ateliers[]    findAll()
 * @method Ateliers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AteliersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ateliers::class);
    }

    // /**
    //  * @return Ateliers[] Returns an array of Ateliers objects
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
    public function findOneBySomeField($value): ?Ateliers
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findById($id)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.id = :id')
            ->setParameter('id', $id)
            ->orderBy('a.dateDebut', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByActivite($activite)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.activite = :activite')
            ->setParameter('activite', $activite)
            ->orderBy('a.dateDebut', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByDate($date)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('YEAR(a.dateDebut) = :date')
            ->setParameter('date', $date)
            ->orderBy('a.dateDebut', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getByActiviteByDate($date, $activite)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('YEAR(a.dateDebut) = :date AND a.activite = :activite')
            ->setParameter('date', $date)
            ->setParameter('activite', $activite)
            ->orderBy('a.dateDebut', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getLastAteliers($date)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.dateDebut >= :date')
            ->setParameter('date', $date)
            ->orderBy('a.dateDebut', 'ASC')
          //  ->setMaxResults(3)
            ->getQuery()
            ->getResult()
            ;
    }

}
