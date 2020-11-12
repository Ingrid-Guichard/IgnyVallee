<?php

namespace App\Controller;




use App\Form\EventsType;

use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints\DateTime;


/**
 * Require ROLE_ADHERENT for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADHERENT")
 *
 */

class CalendarController extends AbstractController
{
    /**
     *
     * @Route("/calendar", name="event_calendar", methods={"GET"})
     */
    public function calendar( AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        return $this->render('admin/calendar.html.twig', [
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            ]);
    }
}

