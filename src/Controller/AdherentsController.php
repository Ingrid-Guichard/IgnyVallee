<?php

namespace App\Controller;


use App\Entity\Adherents;
use App\Entity\Admins;
use App\Entity\Referents;
use App\Entity\Cotisations;
use App\Entity\Participants;
use App\Form\AdherentsType;
use App\Form\EditAdherentsType;
use App\Form\filtres;
use App\Form\DiffusionMailsType;
use App\Form\filtresReferent;
use App\Repository\ActivitesRepository;
use App\Repository\AdherentsRepository;
use App\Repository\AteliersRepository;
use App\Form\InscriptionAteliersType;
use App\Repository\EventsRepository;
use App\Repository\ParticipantsRepository;
use App\Form\ValidateAdherentType;
use App\Form\EventsType;
use App\Repository\AdminsRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\EqualTo;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use swiftmailer;




class AdherentsController extends AbstractController
{
    /* PARTIE GESTION PAR ADMINISTRATEURS */

    /* Pour la partie administrateur, intégré /admin en dur au début de chaque route
   - Chaque entité est écrite avec un -s dans les routes*/

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/adherents", name="adherents_index", methods={"GET","POST"})
     */
    public function indexAdherent(Request $request, AdherentsRepository $adherentsRepository, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $form = $this->createForm(filtres::class);
        $form->handleRequest($request);

        $admins = $form->get('admins')->getData();
        $referentsP = $form->get('referentsP')->getData();
        $referentsR = $form->get('referentsR')->getData();
        $referentsV = $form->get('referentsV')->getData();
        $membresP = $form->get('membresP')->getData();
        $membresR = $form->get('membresR')->getData();
        $membresV = $form->get('membresV')->getData();
        $membresA = $form->get('membresA')->getData();
        $membresPr = $form->get('membresPr')->getData();
        $intsP = $form->get('intsP')->getData();
        $intsR = $form->get('intsR')->getData();
        $intsV = $form->get('intsV')->getData();
        $intsA = $form->get('intsA')->getData();
        $archives = $form->get('archives')->getData();
        $nom = $form->get('nom')->getData();
        $prenom = $form->get('prenom')->getData();
        $anneeCotis = $form->get('anneeCotis')->getData();

        if ($form->isSubmitted() && $form->isValid()) {

            $listeAdherents = [];

            if($admins == false && $referentsP == false && $referentsR == false && $referentsV == false && $membresP == false && $membresR == false && $membresV == false && $membresA == false && $membresPr == false && $intsP == false && $intsR == false && $intsV == false && $intsA == false && $archives == false) {
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByNomAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByNom($nom, $prenom));
                }
            }
            if($admins == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByIsAdminAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByIsAdminFiltre($nom, $prenom));
                }
            }
            if($referentsP == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByIsReferentPAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByIsReferentPFiltre($nom, $prenom));
                }
            }
            if($referentsR == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByIsReferentRAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByIsReferentRFiltre($nom, $prenom));
                }
            }
            if($referentsV == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByIsReferentVAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByIsReferentVFiltre($nom, $prenom));
                }
            }
            if ($membresP == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActPotagerAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActPotagerFiltre($nom, $prenom));
                }
            }
            if ($membresR == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActRucherAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActRucherFiltre($nom, $prenom));
                }
            }
            if ($membresV == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActVergerAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActVergerFiltre($nom, $prenom));
                }
            }
            if ($membresA == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActAnimationAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActAnimationFiltre($nom, $prenom));
                }
            }
            if ($membresPr == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActPromotionAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActPromotionFiltre($nom, $prenom));
                }
            }
            if ($intsP == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentIntPotagerAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentIntPotagerFiltre($nom, $prenom));
                }
            }
            if ($intsR == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentIntRucherAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentIntRucherFiltre($nom, $prenom));
                }
            }
            if ($intsV == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentIntVergerAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentIntVergerFiltre($nom, $prenom));
                }
            }
            if ($intsA == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentIntAnimationAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentIntAnimationFiltre($nom, $prenom));
                }
            }
            if ($archives == true){
                if ($anneeCotis != null) {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentArchiveAndAnneeCotis($nom, $prenom, $anneeCotis));
                } else {
                    $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentArchiveFiltre($nom, $prenom));
                }
            }

            $listeAdherentsFinal = array_unique($listeAdherents, SORT_REGULAR);

            $this->getDoctrine()->getManager()->flush();

            return $this->render('adherents/index.html.twig', [
                'adherents' => $listeAdherentsFinal,
                'form' => $form->createView(),
                'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            ]);

        }

        return $this->render('adherents/index.html.twig', [
            'adherents' => $adherentsRepository->findByNom($nom, $prenom),
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/adherents/excel", name="adherents_index_excel", methods={"GET","POST"})
     */
    public function indexAdherentExcel(AdherentsRepository $adherentsRepository): Response
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $liste = $adherentsRepository->findAll();

        $sheet->setCellValueByColumnAndRow(1,1,'Id');
        $sheet->setCellValueByColumnAndRow(2,1,'Nom');
        $sheet->setCellValueByColumnAndRow(3,1,'Prenom');
        $sheet->setCellValueByColumnAndRow(4,1,'Email');
        $sheet->setCellValueByColumnAndRow(5,1,'Date début adhésion');
        $sheet->setCellValueByColumnAndRow(6,1,'Date fin adhésion');
        $sheet->setCellValueByColumnAndRow(7,1,'Administrateur');
        $sheet->setCellValueByColumnAndRow(8,1,'Référent Potager');
        $sheet->setCellValueByColumnAndRow(9,1,'Référent Rucher');
        $sheet->setCellValueByColumnAndRow(10,1,'Référent Verger');
        $sheet->setCellValueByColumnAndRow(11,1,'Membre Archivé');
        $sheet->setCellValueByColumnAndRow(12,1,'Membre Potager');
        $sheet->setCellValueByColumnAndRow(13,1,'Membre Rucher');
        $sheet->setCellValueByColumnAndRow(14,1,'Membre Verger');
        $sheet->setCellValueByColumnAndRow(15,1,'Membre Animation');
        $sheet->setCellValueByColumnAndRow(16,1,'Membre Promotion');
        $sheet->setCellValueByColumnAndRow(17,1,'Intéressé Potager');
        $sheet->setCellValueByColumnAndRow(18,1,'Intéressé Rucher');
        $sheet->setCellValueByColumnAndRow(19,1,'Intéressé Verger');
        $sheet->setCellValueByColumnAndRow(20,1,'Intéressé Animation');

        for($i = 0; $i < count($liste); ++$i) {
            $sheet->setCellValueByColumnAndRow(1,$i + 2,$liste[$i]->getId());
            $sheet->setCellValueByColumnAndRow(2,$i + 2,$liste[$i]->getNom());
            $sheet->setCellValueByColumnAndRow(3,$i + 2,$liste[$i]->getPrenom());
            $sheet->setCellValueByColumnAndRow(4,$i + 2,$liste[$i]->getEmail());
            $sheet->setCellValueByColumnAndRow(5,$i + 2,$liste[$i]->getDebutAdhesion());
            $sheet->setCellValueByColumnAndRow(6,$i + 2,$liste[$i]->getFinAdhesion());
            $sheet->setCellValueByColumnAndRow(7,$i + 2,$liste[$i]->getIsAdmin());
            $sheet->setCellValueByColumnAndRow(8,$i + 2,$liste[$i]->getIsReferentP());
            $sheet->setCellValueByColumnAndRow(9,$i + 2,$liste[$i]->getIsReferentR());
            $sheet->setCellValueByColumnAndRow(10,$i + 2,$liste[$i]->getIsReferentV());
            $sheet->setCellValueByColumnAndRow(11,$i + 2,$liste[$i]->getIsArchive());
            $sheet->setCellValueByColumnAndRow(12,$i + 2,$liste[$i]->getIsActPotager());
            $sheet->setCellValueByColumnAndRow(13,$i + 2,$liste[$i]->getIsActRucher());
            $sheet->setCellValueByColumnAndRow(14,$i + 2,$liste[$i]->getIsActVerger());
            $sheet->setCellValueByColumnAndRow(15,$i + 2,$liste[$i]->getIsActAnimation());
            $sheet->setCellValueByColumnAndRow(16,$i + 2,$liste[$i]->getIsActPromotion());
            $sheet->setCellValueByColumnAndRow(17,$i + 2,$liste[$i]->getIsIntPotager());
            $sheet->setCellValueByColumnAndRow(18,$i + 2,$liste[$i]->getIsIntRucher());
            $sheet->setCellValueByColumnAndRow(19,$i + 2,$liste[$i]->getIsIntVerger());
            $sheet->setCellValueByColumnAndRow(20,$i + 2,$liste[$i]->getIsIntAnimation());
        }

        $sheet->setTitle("Liste des adhérents");

        $writer = new Xlsx($spreadsheet);

        $fileName = 'liste_adherent.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, 'liste_adherent.xlsx', ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/adherents/valide", name="adherents_liste_a_valider", methods={"GET"})
     */
    public function indexAdherentValide(AdherentsRepository $adherentsRepository, MainController $mainController,
                                        Request $request, AteliersRepository $ateliersRepository,
                                        EventsRepository $eventsRepository): Response
    {
        return $this->render('adherents/listValide.html.twig', [
            'adherents' => $adherentsRepository->findByValide(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/adherents/valide/{id}", name="adherents_a_valide_show", methods={"GET","POST"})
     */
    public function showAdherentValide(Request $request, Adherents $adherent, \Swift_Mailer $mailer,
                                       AdherentsRepository $adherentsRepository, AteliersRepository $ateliersRepository,
                                        EventsRepository $eventsRepository): Response
    {
        $participant = New Participants();
        $validateAdherentForm = $this->createForm(ValidateAdherentType::class, $adherent);
        $validateAdherentForm->handleRequest($request);

        //Récupération des données de l'adhérent
        $emailAdherent = $adherent->getEmail();
        $prenom = $adherent->getPrenom();
        $nom = $adherent->getNom();
        $tel = $adherent->getTelephone();

        $entityManager = $this->getDoctrine()->getManager();


        if ($validateAdherentForm->isSubmitted() && $validateAdherentForm->isValid()) {
            $adherent->setValide(true);
            $adherent->setRoles(['ROLE_ADHERENT']);
            $this->getDoctrine()->getManager()->flush();

            // Création d'un participant pour l'adhérent

            $participant->setEmail($emailAdherent);
            $participant->setNom($nom);
            $participant->setPrenom($prenom);
            $participant->setTelephone($tel);
            $participant->setIsAdherent(true);
            $participant->setTypePaiement(null);
            $participant->setIsPayed(false);
            $participant->setAdherent($adherent);
            $entityManager->persist($participant);
            $entityManager->flush();


            $message = (new \Swift_Message('Adhésion Validée'))
                ->setFrom('perrine.bouey@gmail.com')
                ->setTo($emailAdherent)
                ->setBody(
                    $this->renderView(
                        'emails/valideAdhByAdmin.html.twig',
                        ['prenom' => $prenom, 'nom' => $nom]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $this->redirectToRoute('adherents_liste_a_valider');
        }
        return $this->render('adherents/showValide.html.twig', [
            'adherent' => $adherent,
            'form' => $validateAdherentForm->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/adherents/valide/nonvalide/{id}", name="adherents_nonValide_delete", methods={"DELETE"})
     */
    public function deleteAdherentValide(Request $request, Adherents $adherent, \Swift_Mailer $mailer): Response
    {
        $emailAdherent = $adherent->getEmail();
        $prenom = $adherent->getPrenom();
        $nom = $adherent->getNom();
        if ($this->isCsrfTokenValid('delete'.$adherent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adherent);
            $entityManager->flush();

            $message = (new \Swift_Message('Demande d\'adhésion à l\'association Igny Vallée Comestible rejetée'))
                ->setFrom($this->getParameter('mail'))
                ->setTo($emailAdherent)
                ->setBody(
                    $this->renderView(
                        'emails/refusAdhesion.html.twig',
                        ['prenom' => $prenom, 'nom' => $nom]
                    ),
                    'text/html'
                );
            $mailer->send($message);
        }

        return $this->redirectToRoute('adherents_liste_a_valider');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/adherents/new", name="adherents_new", methods={"GET","POST"})
     */
    public function newAdherent(Request $request, \Swift_Mailer $mailer, ActivitesRepository $activiteRepository,
                                EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
        $adherent = new Adherents();
        $participant = new Participants();
        $form = $this->createForm(AdherentsType::class, $adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Ajout de l'adhérent à la table Adhérents
            $adherent->setRoles(['ROLE_ADHERENT']);

            // Récupération des informations adhérents
            $emailAdherent = $form->get('email')->getData();
            $prenom = $form->get('prenom')->getData();
            $nom = $form->get('nom')->getData();
            $paye = $form->get('isPayed')->getData();
            $tel = $form->get('telephone')->getData();
            $paiement = $form->get('typePaiement')->getData();
            $adhesion = $form->get('typeAdhesion')->getData();
            $potager = $form->get('isActPotager')->getData();

            // Affectation selon activité choisie
            if($potager == true){
              $activite = $activiteRepository->find(1);
              $adherent->addActivite($activite);
            }
            $verger = $form->get('isActVerger')->getData();
            if($verger == true){
              $activite = $activiteRepository->find(3);
              $adherent->addActivite($activite);
            }
            $rucher = $form->get('isActRucher')->getData();
            if($rucher == true){
              $activite = $activiteRepository->find(2);
              $adherent->addActivite($activite);
            }

            $entityManager = $this->getDoctrine()->getManager();

            // Affectation automatique des champs restants
            $adherent->setPassword($this->passwordEncoder->encodePassword($adherent, 'Igny'));
            $dateAdhesion = (new \DateTime);
            list($a,$m,$j)=explode("-",$dateAdhesion->format('Y-m-d H:i:s'));
            $adherent-> setDebutAdhesion((new \DateTime));
            $dateFin = $a . "-12-31";
            $adherent->setFinAdhesion(new \DateTime($dateFin));
            $adherent-> setIsAdmin(false);
            $adherent-> setIsReferentP(false);
            $adherent-> setIsReferentR(false);
            $adherent-> setIsReferentV(false);
            $adherent-> setIsArchive(false);
            $adherent-> setValide(true);

            // Création d'un participant pour l'adhérent
            $participant->setEmail($emailAdherent);
            $participant->setNom($nom);
            $participant->setPrenom($prenom);
            $participant->setTelephone($tel);
            $participant->setIsAdherent(true);
            $participant->setTypePaiement(null);
            $participant->setIsPayed(false);
            $participant->setAdherent($adherent);
            $entityManager->persist($participant);
            $entityManager->flush();


            //Ajout de la cotisation à la table cotisation si l'adhérent a payé
            if($paye == true){
              $cotisation = new Cotisations();
              $dateAdhesion = (new \DateTime);
              list($a,$m,$j)=explode("-",$dateAdhesion->format('Y-m-d H:i:s'));
              $dateFin = $a . "-12-31";
              $cotisation->setDebutCotisation(new \DateTime);
              $cotisation->setFinCotisation(new \DateTime($dateFin));
              $adhesion = $form->get('typeAdhesion')->getData();
              $cotisation->setTypePaiement($paiement);
              $cotisation->setAdherent($adherent);
              $entityManager->persist($cotisation);
              $entityManager->flush();
            }

            $entityManager->persist($adherent);
            $entityManager->flush();

            $message = (new \Swift_Message('Nouvelle adhésion à l\'association Igny Vallée Comestible'))
                ->setFrom($this->getParameter('mail'))
                ->setTo($emailAdherent)
                ->setBody(
                    $this->renderView(
                        'emails/ajoutAdhByAdmin.html.twig',
                        ['prenom' => $prenom, 'nom' => $nom, 'email' => $emailAdherent, 'mdp' => 'Igny', 'status'=>'Vous pouvez maintenant vous connecter sur notre site internet : http://igny-box/login']
                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $this->redirectToRoute('adherents_index');
        }

        return $this->render('adherents/new.html.twig', [
            'adherent' => $adherent,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/adherents/{id}", name="adherents_show", methods={"GET"})
     */
    public function showAdherent(Adherents $adherent, AteliersRepository $ateliersRepository,
                                 EventsRepository $eventsRepository): Response
    {
      $participant = $adherent->getParticipant();
      if($participant != null){
        $events = $participant->getEvents();
      }
      else{
        $events = null;
      }

        return $this->render('adherents/show.html.twig', [
            'adherent' => $adherent, 'listeEvents' => $events,
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/adherents/{id}/edit", name="adherents_edit", methods={"GET","POST"})
     */
    public function editAdherent(Request $request, Adherents $adherent, ActivitesRepository $activitesRepository,
                                 AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $isAdminAvant = $adherent->getIsAdmin();
        $isReferentPAvant = $adherent->getIsReferentP();
        $isReferentRAvant = $adherent->getIsReferentR();
        $isReferentVAvant = $adherent->getIsReferentV();

        $payeold = $adherent->getIsPayed();
        $form = $this->createForm(EditAdherentsType::class, $adherent);
        $form->handleRequest($request);
        $participant = $adherent->getParticipant();

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupération des informations adhérents
            $emailAdherent = $form->get('email')->getData();
            $prenom = $form->get('prenom')->getData();
            $nom = $form->get('nom')->getData();
            $tel = $form->get('telephone')->getData();

            $entityManager = $this->getDoctrine()->getManager();

//             Edition du participant correspondant à l'adhérent
                $participant->setEmail($emailAdherent);
                $participant->setNom($nom);
                $participant->setPrenom($prenom);
                $participant->setTelephone($tel);
                $participant->setIsAdherent(true);
                $participant->setTypePaiement(null);
                $participant->setIsPayed(false);
                $participant->setAdherent($adherent);
                $entityManager->persist($participant);
                $entityManager->flush();



            $isAdminApres = $adherent->getIsAdmin();
            $isReferentPApres = $adherent->getIsReferentP();
            $isReferentRApres = $adherent->getIsReferentR();
            $isReferentVApres = $adherent->getIsReferentV();

            $entityManager = $this->getDoctrine()->getManager();

            if($isAdminApres != $isAdminAvant) {
                if($isAdminApres == true) {
                    $admin = new Admins();
                    $admin->setAdherent($adherent);
                    $admin->setHeuresGestionAdmin(0);
                    $adherent->setRoles(['ROLE_SUPER_ADMIN']);
                    $entityManager->persist($admin);
                    $entityManager->persist($adherent);
                }
                else {
                    $admin = $adherent->getAdmin();
                    $entityManager->remove($admin);
                    $adherent->setRoles(['ROLE_ADHERENT']);
                    $entityManager->persist($adherent);
                }
            }

            if($isReferentPApres != $isReferentPAvant || $isReferentRApres != $isReferentRAvant || $isReferentVApres != $isReferentVAvant) {
                if($isReferentPApres == true || $isReferentRApres == true || $isReferentVApres == true) {

                    if ($adherent->getReferent() == null) {
                        $referent = new Referents();
                        $referent->setAdherent($adherent);
                        $referent->setHeuresGestionReferent(0);
                        $adherent->setRoles(['ROLE_REFERENT']);
                        $entityManager->persist($adherent);
                    }
                    else {
                        $referent = $adherent->getReferent();
                    }

                    if($isReferentPApres != $isReferentPAvant) {
                        if($isReferentPApres == true) {
                            $referent->addActivite($activitesRepository->find(1));
                        }
                        else {
                            $referent->removeActivite($activitesRepository->find(1));
                        }
                    }
                    if($isReferentRApres != $isReferentRAvant) {
                        if($isReferentRApres == true) {
                            $referent->addActivite($activitesRepository->find(2));
                        }
                        else {
                            $referent->removeActivite($activitesRepository->find(2));
                        }
                    }
                    if($isReferentVApres != $isReferentVAvant) {
                        if($isReferentVApres == true) {
                            $referent->addActivite($activitesRepository->find(3));
                        }
                        else {
                            $referent->removeActivite($activitesRepository->find(3));
                        }
                    }
                    $entityManager->persist($referent);
                }
                else {
                    $referent = $adherent->getReferent();
                    $entityManager->remove($referent);
                    $adherent->setRoles(['ROLE_ADHERENT']);
                    $entityManager->persist($adherent);
                }
            }

            $paye = $form->get('isPayed')->getData();
            $paiement = $form->get('typePaiement')->getData();
            $adhesion = $form->get('typeAdhesion')->getData();

            //Ajout de la cotisation à la table cotisation si l'adhérent a payé
            if($paye == true && $payeold == false){
              $cotisation = new Cotisations();
              $dateAdhesion = (new \DateTime);
              list($a,$m,$j)=explode("-",$dateAdhesion->format('Y-m-d H:i:s'));
              $dateFin = $a . "-12-31";
              $cotisation->setDebutCotisation(new \DateTime);
              $cotisation->setFinCotisation(new \DateTime($dateFin));
              $cotisation->setTypeAdhesion($adhesion);
              $cotisation->setTypePaiement($paiement);
              $cotisation->setAdherent($adherent);
              $entityManager->persist($cotisation);
            }

            $entityManager->flush();

            return $this->redirectToRoute('adherents_index');
        }

        return $this->render('adherents/edit.html.twig', [
            'adherent' => $adherent,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/admin/adherents/{id}", name="adherents_delete", methods={"DELETE"})
     */
    public function deleteAdherent(Request $request, Adherents $adherent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adherent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($adherent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adherents_index');
    }

    /* PARTIE GESTION PAR REFERENTS */

    /* Pour la partie référent, intégré /referent en dur au début de chaque route
   - Chaque entité est écrite avec un -s dans les routes*/

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/referent/adherents", name="adherents_index_referent", methods={"GET","POST"})
     */
    public function indexAdherentReferent(Request $request, AdherentsRepository $adherentsRepository): Response
    {
        $form = $this->createForm(filtresReferent::class);
        $form->handleRequest($request);

        $activite= $form->get('activite')->getData();
        $nom= $form->get('nom')->getData();
        $prenom= $form->get('prenom')->getData();

        $listeAdherents = [];

        if ($form->isSubmitted() && $form->isValid()) {

            if ($activite == 'membresP'){
                $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActPotagerFiltre($nom, $prenom));
            }
            if ($activite == 'membresR'){
                $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActRucherFiltre($nom, $prenom));
            }
            if ($activite == 'membresV'){
                $listeAdherents = array_merge($listeAdherents, $adherentsRepository->findByAdherentActVergerFiltre($nom, $prenom));
            }

            $listeAdherentsFinal = array_unique($listeAdherents, SORT_REGULAR);

            $this->getDoctrine()->getManager()->flush();

            return $this->render('adherents/listeAdhPourRef.html.twig', [
                'adherents' => $listeAdherentsFinal,
                'form' => $form->createView(),
            ]);
        }

        return $this->render('adherents/listeAdhPourRef.html.twig', [
            'adherents' => $listeAdherents,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/referent/adherents/{id}", name="adherents_show_referent", methods={"GET"})
     */
    public function showAdherentReferent(Adherents $adherent, AteliersRepository $ateliersRepository,
                                 EventsRepository $eventsRepository): Response
    {
        $participant = $adherent->getParticipant();
        if($participant != null){
            $events = $participant->getEvents();
        }
        else{
            $events = null;
        }

        return $this->render('adherents/showPourReferent.html.twig', [
            'adherent' => $adherent, 'listeEvents' => $events,
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

}
