<?php

namespace App\Repository;

use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Events|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events[]    findAll()
 * @method Events[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events::class);
    }

    // /**
    //  * @return Events[] Returns an array of Events objects
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
    public function findOneBySomeField($value): ?Events
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByDate($date)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('YEAR(e.dateDebut) = :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByNom($nom)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom LIKE :nom')
            ->setParameter('nom', $nom.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getByNomByDate($date, $nom)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('YEAR(e.dateDebut) = :date AND e.nom LIKE :nom')
            ->setParameter('date', $date)
            ->setParameter('nom', $nom.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getLastEvents($date)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.dateDebut >= :date')
            ->setParameter('date', $date)
            ->orderBy('e.dateDebut', 'ASC')
            //  ->setMaxResults(3)
            ->getQuery()
            ->getResult()
            ;
    }
}
