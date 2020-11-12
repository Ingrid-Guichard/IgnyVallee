<?php

namespace App\Repository;

use App\Entity\Ruchers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ruchers|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ruchers|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ruchers[]    findAll()
 * @method Ruchers[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RuchersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ruchers::class);
    }

    // /**
    //  * @return Ruchers[] Returns an array of Ruchers objects
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
    public function findOneBySomeField($value): ?Ruchers
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
            ->andWhere('r.nomRucher LIKE :nom')
            ->setParameter('nom', $nom.'%')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByDate($date)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('YEAR(r.dateCreationRucher) = :date')
            ->setParameter('date', $date)
            ->getQuery()
            ->getResult()
            ;
    }

    public function getByNomByDate($date, $nom)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('YEAR(r.dateCreationRucher) = :date AND r.nomRucher LIKE :nom')
            ->setParameter('date', $date)
            ->setParameter('nom', $nom.'%')
            ->getQuery()
            ->getResult()
            ;
    }

}
