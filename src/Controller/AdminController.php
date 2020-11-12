<?php

namespace App\Controller;



use App\Entity\Adherents;
use App\Entity\Admins;
use App\Entity\Referents;
use App\Form\AdherentsType;
use App\Form\EditAdherentsType;
use App\Form\EditHeuresAdminType;
use App\Form\EditHeuresReferentType;
use App\Form\ReferentsType;
use App\Repository\AdherentsRepository;
use App\Form\ValidateAdherentType;
use App\Entity\Events;
use App\Form\EditEventsType;
use App\Form\EventsType;
use App\Form\AdminsType;
use App\Form\DiffusionMailsType;
use App\Repository\AdminsRepository;
use App\Form\NewEventsType;
use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use App\Repository\ReferentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Constraints\DateTime;
use Swift_Mailer;
use Swift_Message;
use swiftmailer;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 *
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
    * Require ROLE_ADMIN for only this controller method.
    * @Route("/", name="app_adminpage_dashboard")
    *
    * @IsGranted("ROLE_ADMIN")
    */
    public function adminDashboard()
    {
        return $this->render('admin/dashboard.html.twig');
    }


    /**
     * @Route("/modifarticles", name="app_modifarticles")
     */
    public function modifarticles(Environment $twigEnvironment)
    {
        return $this->render('admin/modifarticles.html.twig');
    }

    /**
     * @Route("/heures", name="heures_gestion_admins", methods={"GET"})
     */
    public function gestionHeures(AdminsRepository $adminsRepository, ReferentsRepository $referentsRepository, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository) : Response
    {
        return $this->render('admin/heures.html.twig', [
            'admins' => $adminsRepository->findAll(),
            'referents' => $referentsRepository->findAll(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/heures/admins/{id}/edit", name="heures_gestion_admins_edit", methods={"GET","POST"})
     */

    public function editHeuresAdmin(Request $request, Admins $admin, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $form = $this->createForm(EditHeuresAdminType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('heures_gestion_admins');
        }

        return $this->render('admin/editHeuresAdmins.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/heures/referents/{id}/edit", name="heures_gestion_referents_edit", methods={"GET","POST"})
     */

    public function editHeuresReferent(Request $request, Referents $referent, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $form = $this->createForm(EditHeuresReferentType::class, $referent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('heures_gestion_admins');
        }

        return $this->render('admin/editHeuresReferents.html.twig', [
            'referent' => $referent,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/diffusion", name="diffusion_mails", methods={"GET","POST"})
     */
    public function diffusionMailsAdherent(Request $request, \Swift_Mailer $mailer, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
      $form = $this->createForm(DiffusionMailsType::class);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
        return $this->redirectToRoute('app_homepage');
      }
        return $this->render('admin/diffusion_mails.html.twig', [
          'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

}
