<?php

namespace App\Controller;

use App\Entity\FichesDeVisite;
use App\Entity\Ruches;
use App\Form\FichesDeVisiteType;
use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use App\Repository\FichesDeVisiteRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Repository\RuchersRepository;
use App\Repository\RuchesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/fiches/de/visite")
 */
class FichesDeVisiteController extends AbstractController
{
    /**
     * @IsGranted ("ROLE_ADHERENT")
     * @Route("/", name="fiches_de_visite_index", methods={"GET"})
     */
    public function index(FichesDeVisiteRepository $fichesDeVisiteRepository, RuchesRepository $ruchesRepository,
                          RuchersRepository $ruchersRepository, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        return $this->render('fiches_de_visite/index.html.twig', [
            'fiches_de_visites' => $fichesDeVisiteRepository->findAll(),
            'ruches' => $ruchesRepository->findAll(),
            'rucher' => $ruchersRepository->findAll(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/excel", name="fdv_index_excel", methods={"GET","POST"})
     */
    public function indexAdherentExcel(FichesDeVisiteRepository $fichesDeVisiteRepository): Response
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $liste = $fichesDeVisiteRepository->findAll();

        $sheet->setCellValueByColumnAndRow(1,1,'Rucher');
        $sheet->setCellValueByColumnAndRow(2,1,'Ruche');
        $sheet->setCellValueByColumnAndRow(3,1,'Date');
        $sheet->setCellValueByColumnAndRow(4,1,'Visiteur');
        $sheet->setCellValueByColumnAndRow(5,1,'Type de visite');
        $sheet->setCellValueByColumnAndRow(6,1,'Durée');
        $sheet->setCellValueByColumnAndRow(7,1,'Objectifs');
        $sheet->setCellValueByColumnAndRow(8,1,'Observations');
        $sheet->setCellValueByColumnAndRow(9,1,'Poids de la ruche');
        $sheet->setCellValueByColumnAndRow(10,1,'Taux aggressivité abeilles');
        $sheet->setCellValueByColumnAndRow(11,1,'Volume nourrissement');
        $sheet->setCellValueByColumnAndRow(12,1,'Sirop nourrissement');
        $sheet->setCellValueByColumnAndRow(13,1,'Nombre abeilles');
        $sheet->setCellValueByColumnAndRow(14,1,'Nombre cadres couvain');
        $sheet->setCellValueByColumnAndRow(15,1,'Nombre cadres miel');
        $sheet->setCellValueByColumnAndRow(16,1,'Nombre cadres pollen');
        $sheet->setCellValueByColumnAndRow(17,1,'Comptage Varroa');
        $sheet->setCellValueByColumnAndRow(18,1,'Types de couvains');
        $sheet->setCellValueByColumnAndRow(19,1,'Cellules royales');
        $sheet->setCellValueByColumnAndRow(20,1,'Détection de la reine');
        $sheet->setCellValueByColumnAndRow(21,1,'Naissance de la reine');
        $sheet->setCellValueByColumnAndRow(22,1,'Réserve de pollen');
        $sheet->setCellValueByColumnAndRow(23,1,'Réserve de miel');
        $sheet->setCellValueByColumnAndRow(24,1,'Cadre n°1');
        $sheet->setCellValueByColumnAndRow(25,1,'Cadre n°2');
        $sheet->setCellValueByColumnAndRow(26,1,'Cadre n°3');
        $sheet->setCellValueByColumnAndRow(27,1,'Cadre n°4');
        $sheet->setCellValueByColumnAndRow(28,1,'Cadre n°5');
        $sheet->setCellValueByColumnAndRow(29,1,'Cadre n°6');
        $sheet->setCellValueByColumnAndRow(30,1,'Cadre n°7');
        $sheet->setCellValueByColumnAndRow(31,1,'Cadre n°8');
        $sheet->setCellValueByColumnAndRow(32,1,'Cadre n°9');
        $sheet->setCellValueByColumnAndRow(33,1,'Cadre n°10');
        $sheet->setCellValueByColumnAndRow(34,1,'Structure cadre n°1');
        $sheet->setCellValueByColumnAndRow(35,1,'Structure cadre n°2');
        $sheet->setCellValueByColumnAndRow(36,1,'Structure cadre n°3');
        $sheet->setCellValueByColumnAndRow(37,1,'Structure cadre n°4');
        $sheet->setCellValueByColumnAndRow(38,1,'Structure cadre n°5');
        $sheet->setCellValueByColumnAndRow(39,1,'Structure cadre n°6');
        $sheet->setCellValueByColumnAndRow(40,1,'Structure cadre n°7');
        $sheet->setCellValueByColumnAndRow(41,1,'Structure cadre n°8');
        $sheet->setCellValueByColumnAndRow(42,1,'Structure cadre n°9');
        $sheet->setCellValueByColumnAndRow(43,1,'Structure cadre n°10');


        for($i = 0; $i < count($liste); ++$i) {
            $sheet->setCellValueByColumnAndRow(1,$i + 2,$liste[$i]->getRuche()->getRucher()->getNomRucher());
            $sheet->setCellValueByColumnAndRow(2,$i + 2,$liste[$i]->getRuche()->getNomRuche());
            $sheet->setCellValueByColumnAndRow(3,$i + 2,$liste[$i]->getDateVisite());
            $sheet->setCellValueByColumnAndRow(4,$i + 2,"{$liste[$i]->getAdherent()->getPrenom()} {$liste[$i]->getAdherent()->getNom()} ({$liste[$i]->getAdherent()->getId()})");
            $sheet->setCellValueByColumnAndRow(5,$i + 2,$liste[$i]->getTypeVisite());
            $sheet->setCellValueByColumnAndRow(6, $i + 2,$liste[$i]->getTempsVisite());
            $sheet->setCellValueByColumnAndRow(7,$i + 2,$liste[$i]->getObjectifs());
            $sheet->setCellValueByColumnAndRow(8,$i + 2,$liste[$i]->getObservations());
            $sheet->setCellValueByColumnAndRow(9,$i + 2,$liste[$i]->getPoidsRuche());
            $sheet->setCellValueByColumnAndRow(10,$i + 2,$liste[$i]->getTauxAgressiviteAbeilles());
            $sheet->setCellValueByColumnAndRow(11,$i + 2,$liste[$i]->getNourrissement());
            $sheet->setCellValueByColumnAndRow(12, $i + 2,$liste[$i]->getTypeSirop());
            $sheet->setCellValueByColumnAndRow(13, $i + 2,$liste[$i]->getQuantiteAbeilles());
            $sheet->setCellValueByColumnAndRow(14, $i + 2,$liste[$i]->getNbCadresCouvain());
            $sheet->setCellValueByColumnAndRow(15, $i + 2,$liste[$i]->getNbCadresMiel());
            $sheet->setCellValueByColumnAndRow(16, $i + 2,$liste[$i]->getNbCadresPollen());
            $sheet->setCellValueByColumnAndRow(17, $i + 2,$liste[$i]->getCalculVarroa());
            $sheet->setCellValueByColumnAndRow(18,$i + 2,implode(",", $liste[$i]->getTypeCouvain()));
            $sheet->setCellValueByColumnAndRow(19, $i + 2,$liste[$i]->getCellulesRoyales());
            $sheet->setCellValueByColumnAndRow(20, $i + 2,$liste[$i]->getDetectionReine());
            $sheet->setCellValueByColumnAndRow(21,$i + 2,$liste[$i]->getRuche()->getNaissanceReine());
            $sheet->setCellValueByColumnAndRow(22, $i + 2,$liste[$i]->getReservePollen());
            $sheet->setCellValueByColumnAndRow(23, $i + 2,$liste[$i]->getReserveMiel());
            $sheet->setCellValueByColumnAndRow(24, $i + 2,$liste[$i]->getCadre1());
            $sheet->setCellValueByColumnAndRow(25, $i + 2,$liste[$i]->getCadre2());
            $sheet->setCellValueByColumnAndRow(26, $i + 2,$liste[$i]->getCadre3());
            $sheet->setCellValueByColumnAndRow(27, $i + 2,$liste[$i]->getCadre4());
            $sheet->setCellValueByColumnAndRow(28, $i + 2,$liste[$i]->getCadre5());
            $sheet->setCellValueByColumnAndRow(29, $i + 2,$liste[$i]->getCadre6());
            $sheet->setCellValueByColumnAndRow(30, $i + 2,$liste[$i]->getCadre7());
            $sheet->setCellValueByColumnAndRow(31, $i + 2,$liste[$i]->getCadre8());
            $sheet->setCellValueByColumnAndRow(32, $i + 2,$liste[$i]->getCadre9());
            $sheet->setCellValueByColumnAndRow(33, $i + 2,$liste[$i]->getCadre10());
            $sheet->setCellValueByColumnAndRow(34, $i + 2,$liste[$i]->getTypeStructure1());
            $sheet->setCellValueByColumnAndRow(35, $i + 2,$liste[$i]->getTypeStructure2());
            $sheet->setCellValueByColumnAndRow(36, $i + 2,$liste[$i]->getTypeStructure3());
            $sheet->setCellValueByColumnAndRow(37, $i + 2,$liste[$i]->getTypeStructure4());
            $sheet->setCellValueByColumnAndRow(38, $i + 2,$liste[$i]->getTypeStructure5());
            $sheet->setCellValueByColumnAndRow(39, $i + 2,$liste[$i]->getTypeStructure6());
            $sheet->setCellValueByColumnAndRow(40, $i + 2,$liste[$i]->getTypeStructure7());
            $sheet->setCellValueByColumnAndRow(41, $i + 2,$liste[$i]->getTypeStructure8());
            $sheet->setCellValueByColumnAndRow(42, $i + 2,$liste[$i]->getTypeStructure9());
            $sheet->setCellValueByColumnAndRow(43, $i + 2,$liste[$i]->getTypeStructure10());
        }

        $sheet->setTitle("Index des fiches de visite");

        $writer = new Xlsx($spreadsheet);

        $fileName = "index_fdv.xlsx";
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @IsGranted ("ROLE_ADHERENT")
     * @Route("/{id}/new/fichesvisite", name="fiches_de_visite_new", methods={"GET","POST"})
     */
    public function new(Ruches $ruch, Request $request, RuchesRepository $ruchesRepository,
                        AteliersRepository $ateliersRepository, EventsRepository $eventsRepository,
                        FichesDeVisiteRepository $fichesDeVisiteRepository): Response
    {
        $fichesDeVisite = new FichesDeVisite();
        $form = $this->createForm(FichesDeVisiteType::class, $fichesDeVisite);
        $form->handleRequest($request);
        $rucher = $ruch->getRucher();

        if ($form->isSubmitted() && $form->isValid()) {
            $adherent = $this->security->getUser();
            $fichesDeVisite->setAdherent($adherent);
            $ruch->addFichesDeVisite($fichesDeVisite);
            $fichesDeVisite ->setRuche($ruch);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fichesDeVisite);
            $entityManager->persist($ruch);
            $entityManager->flush();

            return $this->render('ruches/indexByRuche.html.twig', [
                'rucher'=> $rucher,
                'ruch' => $ruch,
                'fiches_de_visites' => $fichesDeVisiteRepository -> findByRuche($ruch),
                'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
                'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            ]);
        }

        return $this->render('fiches_de_visite/new.html.twig', [
            'fiches_de_visite' => $fichesDeVisite,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted ("ROLE_ADHERENT")
     * @Route("/{id}", name="fiches_de_visite_show", methods={"GET"})
     */
    public function show(FichesDeVisite $fichesDeVisite, AteliersRepository $ateliersRepository,
                         EventsRepository $eventsRepository): Response
    {
        return $this->render('fiches_de_visite/show.html.twig', [
            'fiches_de_visite' => $fichesDeVisite,
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted ("ROLE_REFERENT")
     * @Route("/{id}/edit", name="fiches_de_visite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, FichesDeVisite $fichesDeVisite,
                         AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $form = $this->createForm(FichesDeVisiteType::class, $fichesDeVisite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fiches_de_visite_index');
        }

        return $this->render('fiches_de_visite/edit.html.twig', [
            'fiches_de_visite' => $fichesDeVisite,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted ("ROLE_REFERENT")
     * @Route("/{id}", name="fiches_de_visite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, FichesDeVisite $fichesDeVisite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fichesDeVisite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fichesDeVisite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fiches_de_visite_index');
    }
}
