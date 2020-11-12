<?php

namespace App\Controller;

use App\Entity\Participants;
use App\Form\DesinscriptionType;
use App\Form\InscriptionType;
use App\Entity\Events;
use App\Form\EditEventsType;
use App\Form\FiltresEventsType;
use App\Form\InscriptionVisiteurType;
use App\Form\NewEventsType;
use App\Form\ValidateEventsType;
use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class EventsController extends AbstractController {

    /* PARTIE GESTION PAR ADMINISTRATEURS */

    /* Pour la partie administrateur, intégré /admin en dur au début de chaque route
    - Chaque entité est écrite avec un -s dans les routes*/

    /**
     *
     * @Route("/events", name="events_index", methods={"GET", "POST"})
     *
     */
    public function indexEvent(EventsRepository $eventsRepository, Request $request, AteliersRepository $ateliersRepository): Response
    {

        $form = $this->createForm(FiltresEventsType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nom = $form->get('nom')->getData();
            $date = $form->get('date')->getData();

            $listeEvents = [];
            if ($nom != null && $date == null) {
                $listeEvents = array_merge($listeEvents, $eventsRepository->findByNom($nom));
            }
            if ($nom == null && $date != null) {
                $listeEvents = array_merge($listeEvents, $eventsRepository->findByDate($date));
            }
            if ($nom != null && $date != null) {
                $listeEvents = array_merge($listeEvents, $eventsRepository->getByNomByDate($date, $nom));
            }
            if ($nom == null && $date == null) {
                $listeEvents = array_merge($listeEvents, $eventsRepository->findAll());
            }
            $listeEventsFinal = array_unique($listeEvents, SORT_REGULAR);
            $form = $this->createForm(FiltresEventsType::class);


            return $this->render('events/index.html.twig', [
                'form' => $form->createView(),
                'events' => $listeEventsFinal,
                'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            ]);
        }

        return $this->render('events/index.html.twig', [
            'form' => $form->createView(),
            'events' => $eventsRepository->findAll(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);

    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/events/new", name="events_new", methods={"GET","POST"})
     */
    public function newEvent(Request $request, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $event = new Events();
        $createEventForm = $this->createForm(NewEventsType::class, $event);
        $createEventForm->handleRequest($request);

        if ($createEventForm->isSubmitted() && $createEventForm->isValid()) {
            $event -> setHeuresGestionEvent(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('event_calendar');
        }

        return $this->render('events/new.html.twig', [
            'event' => $event,
            'form' => $createEventForm->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     *
     * @Route("/events/{id}", name="events_show", methods={"GET", "POST"}, requirements={"id"="\d+"})
     */
    public function showEvent(Events $event, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository,
                              Request $request): Response
    {
            return $this->render('events/show.html.twig', [
            'event' => $event,
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'eventIns' => $this->inscriptionEvents($request, $event)->createView(),
            'eventDesins' => $this->desinscriptionEvents($request, $event)->createView(),
            'eventInsVisiteur' => $this->inscriptionVisiteurEvents($request, $event)->createView(),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/events/{id}/excel", name="events_participants_excel", methods={"GET","POST"}, requirements={"id"="\d+"})
     */
    public function indexAdherentExcel(Events $event, Request $request): Response
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $liste = $event->getParticipants();

        $sheet->setCellValueByColumnAndRow(1,1,'Nom');
        $sheet->setCellValueByColumnAndRow(2,1,'Prenom');
        $sheet->setCellValueByColumnAndRow(3,1,'Email');

        for($i = 0; $i < count($liste); ++$i) {
            $sheet->setCellValueByColumnAndRow(1,$i + 2,$liste[$i]->getNom());
            $sheet->setCellValueByColumnAndRow(2,$i + 2,$liste[$i]->getPrenom());
            $sheet->setCellValueByColumnAndRow(3,$i + 2,$liste[$i]->getEmail());
        }

        $sheet->setTitle("Liste des participants {$event->getId()}");

        $writer = new Xlsx($spreadsheet);

        $fileName = "liste_participants_{$event->getId()}_{$event->getNom()}.xlsx";
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/events/{id}/edit", name="events_edit", methods={"GET","POST"})
     */
    public function editEvent(Request $request, Events $event, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository ): Response
    {
        $editEventForm = $this->createForm(EditEventsType::class, $event);
        $editEventForm->handleRequest($request);

        if ($editEventForm->isSubmitted() && $editEventForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/edit.html.twig', [
            'event' => $event,
            'form' => $editEventForm->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/events/{id}", name="events_delete", methods={"DELETE"})
     */
    public function deleteEvent(Request $request, Events $event): Response
    {
        if ($this->isCsrfTokenValid('delete'.$event->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($event);
            $entityManager->flush();
        }

        return $this->redirectToRoute('events_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/events/{id}/validate", name="events_validate", methods={"GET","POST"})
     */
    public function validateEvent(Request $request, Events $event, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $validateEventForm = $this->createForm(ValidateEventsType::class, $event);
        $validateEventForm->handleRequest($request);

        if ($validateEventForm->isSubmitted() && $validateEventForm->isValid()) {
            $heures = $validateEventForm->get('heuresGestionEvent')->getData();
            $admins = $validateEventForm->get('admins')->getData();

            foreach ($admins as $admin)
            {
                $admin->addHeuresGestionAdmin($heures);

            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('events_index');
        }

        return $this->render('events/validate.html.twig', [
            'event' => $event,
            'form' => $validateEventForm->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }


    /* FIN DE LA PARTIE GESTION PAR ADMINISTRATEURS */

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    public function inscriptionEvents(Request $request, Events $event)
    {
        $form = $this->createForm(InscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $adherent = $this->security->getUser();
            $participant = $adherent -> getParticipant();
            $event->addParticipant($participant);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
        }
        return $form;
    }

    public function desinscriptionEvents(Request $request, Events $event)
    {
        $form = $this->createForm(DesinscriptionType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $adherent = $this->security->getUser();
            $participant = $adherent -> getParticipant();
            $event->removeParticipant($participant);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($event);
            $entityManager->flush();
        }
        return $form;
    }

    public function inscriptionVisiteurEvents(Request $request, Events $event)
    {
        $participant = New Participants();
        $form = $this->createForm(InscriptionVisiteurType::class, $participant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $entityManager = $this->getDoctrine()->getManager();

            $participant->setIsPayed(false);
            $participant->setTypePaiement(null);
            $participant->setIsAdherent(false);
            $entityManager->persist($participant);
            $entityManager->flush();

            $event->addParticipant($participant);
            $entityManager->persist($event);
            $entityManager->flush();
        }
        return $form;
    }
}