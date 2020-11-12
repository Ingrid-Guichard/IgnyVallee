<?php

namespace App\Repository;

use App\Entity\Adherents;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Adherents|null find($id, $lockMode = null, $lockVersion = null)
 * @method Adherents|null findOneBy(array $criteria, array $orderBy = null)
 * @method Adherents[]    findAll()
 * @method Adherents[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdherentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Adherents::class);
    }

    // /**
    //  * @return Adherents[] Returns an array of Adherents objects
    //  */
    public function findByValide()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.valide = false')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByActif()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isArchive = false')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByActifByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isArchive = false AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByIsAdmin()
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isAdmin = true')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsAdminByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isAdmin = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsAdminFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isAdmin = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByIsAdminAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isAdmin = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsReferent()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isReferentP = true OR a.isReferentR = true OR a.isReferentV = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByIsReferentByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('(a.isReferentP = true OR a.isReferentR = true OR a.isReferentV = true) AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByOnlyAdherent()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isReferentP = false AND a.isReferentR = false AND a.isReferentV = false AND a.isAdmin = false')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByOnlyAdherentByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isReferentP = false AND a.isReferentR = false AND a.isReferentV = false AND a.isAdmin = false AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActPotager()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActPotager = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActPotagerByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActPotager = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActPotagerFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isActPotager = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentActPotagerAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isActPotager = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentActRucher()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActRucher = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActRucherByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActRucher = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActRucherFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isActRucher = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentActRucherAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isActRucher = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentActVerger()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActVerger = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActVergerByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActVerger = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActVergerFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isActVerger = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentActVergerAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isActVerger = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentActAnimation()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActAnimation = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActAnimationByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActAnimation = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActAnimationFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isActAnimation = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentActAnimationAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isActAnimation = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentActPromotion()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActPromotion = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActPromotionByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isActPromotion = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentActPromotionFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isActPromotion = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentActPromotionAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isActPromotion = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentIntAnimation()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isIntAnimation = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentIntAnimationByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isIntAnimation = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentIntAnimationFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isIntAnimation = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentIntAnimationAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isIntAnimation = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentIntPotager()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isIntPotager = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentIntPotagerByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isIntPotager = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentIntPotagerFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isIntPotager = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentIntPotagerAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isIntPotager = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentIntVerger()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isIntVerger = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentIntVergerByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isIntVerger = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentIntVergerFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isIntVerger = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentIntVergerAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isIntVerger = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentIntRucher()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isIntRucher = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentIntRucherByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isIntRucher = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentIntRucherFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isIntRucher = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentIntRucherAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isIntRucher = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentArchive()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isArchive = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentArchiveByDate($annee)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isArchive = true AND YEAR(a.debutAdhesion) = :annee')
            ->setParameter('annee', $annee)
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findByAdherentArchiveFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isArchive = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByAdherentArchiveAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isArchive = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    /*
    public function findOneBySomeField($value): ?Adherents
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findByIsReferentP()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isReferentP = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
    public function findByIsReferentPFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isReferentP = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsReferentPAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isReferentP = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsReferentR()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isReferentR = true')
            //->orderBy('a.debutAdhesion', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsReferentRFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isReferentR = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsReferentRAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isReferentR = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsReferentV()
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.isReferentV = true')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsReferentVFiltre($nom, $prenom)
    {
        return $this->createQueryBuilder('a')

            ->andWhere('a.isReferentV = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByIsReferentVAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.isReferentV = true AND a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByNom($nom, $prenom)
    {
        return $this->createQueryBuilder('a')
            ->where('a.nom LIKE :nom AND a.prenom LIKE :prenom')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByNomAndAnneeCotis($nom, $prenom, $anneeCotis)
    {
        return $this->createQueryBuilder('a')
            ->where('a.nom LIKE :nom AND a.prenom LIKE :prenom AND YEAR(a.debutAdhesion) = :anneeCotis')
            ->setParameter('nom', $nom.'%')
            ->setParameter('prenom', $prenom.'%')
            ->setParameter('anneeCotis', $anneeCotis)
            ->orderBy('a.nom', 'ASC')
            ->getQuery()
            ->getResult()
            ;
    }
}
