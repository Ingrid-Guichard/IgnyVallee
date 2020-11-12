<?php


namespace App\Controller;

use App\Entity\Events;
use App\Form\EditEventsType;
use App\Form\EventsType;
use App\Form\NewEventsType;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_REFERENT")
 *
 * @Route("/referent")
 */
class ReferentController extends AbstractController
{
    /**
     * Require ROLE_REFERENT for only this controller method.
     * @Route("/", name="app_referent_dashboard")
     * @IsGranted("ROLE_REFERENT")
     */
    public function referentDashboard()
    {
        return $this->render('referent/dashboard.html.twig');
    }
}