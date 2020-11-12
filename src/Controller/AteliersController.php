<?php

namespace App\Controller;

use App\Entity\Ateliers;
use App\Form\DesinscriptionType;
use App\Form\FiltresAteliersType;
use App\Form\InscriptionType;
use App\Form\NewAteliersType;
use App\Form\EditAteliersType;
use App\Form\ValidateAteliersType;
use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;



class AteliersController extends AbstractController
{
    /* PARTIE GESTION PAR ADMINISTRATEURS */

    /**
     * @IsGranted("ROLE_ADHERENT")
     * @Route("/ateliers", name="ateliers_index", methods={"GET", "POST"})
     */
    public function indexAtelier(AteliersRepository $ateliersRepository, Request $request, EventsRepository $eventsRepository): Response
    {

        $form = $this->createForm(FiltresAteliersType::class);
        $form->handleRequest($request);



        if ($form->isSubmitted() && $form->isValid()) {

            $verger = $form->get('verger')->getData();
            $potager = $form->get('potager')->getData();
            $rucher = $form->get('rucher')->getData();
            $date = $form->get('date')->getData();

            $listeAteliers = [];
            if($potager == true && $date == null){
                $listeAteliers = array_merge($listeAteliers, $ateliersRepository->findByActivite(1));
            }
            if($rucher == true && $date == null){
                $listeAteliers = array_merge($listeAteliers, $ateliersRepository->findByActivite(2));
            }
            if($verger == true && $date == null){
                $listeAteliers = array_merge($listeAteliers, $ateliersRepository->findByActivite(3));
            }
            if(($date != null) && ($potager == true || $rucher == true || $verger == true)) {
                if($potager == true){
                    $listeAteliers = array_merge($listeAteliers, $ateliersRepository->getByActiviteByDate($date, 1));

                }
                if($rucher == true){
                    $listeAteliers = array_merge($listeAteliers, $ateliersRepository->getByActiviteByDate($date, 2));

                }
                if($verger == true){
                    $listeAteliers = array_merge($listeAteliers, $ateliersRepository->getByActiviteByDate($date, 3));

                }
            }
            if(($date != null) && ($potager == false && $rucher == false && $verger == false)) {
                $listeAteliers = array_merge($listeAteliers, $ateliersRepository->findByDate($date));
            }

            if(($date == null) && ($potager == false && $rucher == false && $verger == false)) {
                $listeAteliers = array_merge($listeAteliers, $ateliersRepository->findBy(
                    array(),
                    array('dateDebut' => 'DESC')
                ));
            }


            $listeAtelierFinal = array_unique($listeAteliers, SORT_REGULAR);
            $form = $this->createForm(FiltresAteliersType::class);

            return $this->render('ateliers/index.html.twig', [
                'form' => $form->createView(),
                'ateliers' => $listeAtelierFinal,
                'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            ]);
        }

        return $this->render('ateliers/index.html.twig', [
            'ateliers' => $ateliersRepository->findBy(
                array(),
                array('dateDebut' => 'DESC')
            ),
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADHERENT")
     * @Route("/ateliers/{id}", name="ateliers_show", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function showAtelier(Ateliers $atelier, AteliersRepository $ateliersRepository, Request $request, EventsRepository $eventsRepository): Response
    {
        return $this->render('ateliers/show.html.twig', [
            'atelier' => $atelier,
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'atelierIns' => $this->inscriptionAtelier($request, $atelier)->createView(),
            'atelierDesins' => $this->desinscriptionAtelier($request, $atelier)->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/ateliers/{id}/excel", name="ateliers_participants_excel", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function indexAdherentExcel(Ateliers $atelier, Request $request): Response
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $liste = $atelier->getAdherents();

        $sheet->setCellValueByColumnAndRow(1,1,'Nom');
        $sheet->setCellValueByColumnAndRow(2,1,'Prenom');
        $sheet->setCellValueByColumnAndRow(3,1,'Email');

        for($i = 0; $i < count($liste); ++$i) {
            $sheet->setCellValueByColumnAndRow(1,$i + 2,$liste[$i]->getNom());
            $sheet->setCellValueByColumnAndRow(2,$i + 2,$liste[$i]->getPrenom());
            $sheet->setCellValueByColumnAndRow(3,$i + 2,$liste[$i]->getEmail());
        }

        $sheet->setTitle("Liste des participants {$atelier->getId()}");

        $writer = new Xlsx($spreadsheet);

        $fileName = "liste_participants_{$atelier->getId()}_{$atelier->getNom()}.xlsx";
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/ateliers/new", name="ateliers_new", methods={"GET","POST"})
     */
    public function newAtelier(Request $request, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $atelier = new Ateliers();
        $form = $this->createForm(NewAteliersType::class, $atelier);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $atelier -> setHeuresGestionAtelier(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($atelier);
            $entityManager->flush();

            return $this->redirectToRoute('ateliers_index');
        }

        return $this->render('ateliers/new.html.twig', [
            'atelier' => $atelier,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);

    }

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/ateliers/{id}/edit", name="ateliers_edit", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function editAtelier(Request $request, Ateliers $atelier, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $form = $this->createForm(EditAteliersType::class, $atelier);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('ateliers_index');
        }

        return $this->render('ateliers/edit.html.twig', [
            'atelier' => $atelier,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/ateliers/{id}", name="ateliers_delete", methods={"DELETE"}, requirements={"page"="\d+"})
     */
    public function deleteAtelier(Request $request, Ateliers $atelier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$atelier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($atelier);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ateliers_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/ateliers/{id}/validate", name="ateliers_validate", methods={"GET","POST"}, requirements={"page"="\d+"})
     */
    public function validateAtelier(Request $request, Ateliers $atelier, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $validateAteliersForm = $this->createForm(ValidateAteliersType::class, $atelier);
        $validateAteliersForm->handleRequest($request);

        if ($validateAteliersForm->isSubmitted() && $validateAteliersForm->isValid()) {
            $heures = $validateAteliersForm->get('heuresGestionAtelier')->getData();
            $referents = $validateAteliersForm->get('referents')->getData();

            foreach ($referents as $referent)
            {
                $referent->addHeuresGestionReferent($heures);

            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ateliers_index');
        }

        return $this->render('ateliers/validate.html.twig', [
            'atelier' => $atelier,
            'form' => $validateAteliersForm->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /* Inscription pour atelier

    /**
     * @var Security
     */
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function inscriptionAtelier(Request $request, Ateliers $atelier)
    {
        $form = $this->createForm(InscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $adherent = $this->security->getUser();
            $atelier->addAdherent($adherent);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($atelier);
            $entityManager->flush();
        }
        return $form;
    }

    public function desinscriptionAtelier(Request $request, Ateliers $atelier)
    {
        $form = $this->createForm(DesinscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $adherent = $this->security->getUser();
            $atelier->removeAdherent($adherent);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($atelier);
            $entityManager->flush();
        }
        return $form;
    }



}
