<?php

namespace App\Controller;


use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use App\Repository\ArticlesRepository;
use App\Form\InscriptionAteliersType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ContactType;
use swiftmailer;
use App\Repository\PartenairesRepository;
use Symfony\Component\Security\Core\Security;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(Environment $twigEnvironment, ArticlesRepository $articlesRepository, Request $request, \Swift_Mailer $mailer, EventsRepository $eventsRepository)
    {
        $cotis = 'pas_a_jour';
        $annee = (new \DateTime)->format('Y');

        return $this->render('static/index.html.twig', [
            'cotis' => $cotis,
            'annee' => $annee,
            'form' => $this->contact($request, $mailer)->createView(),
            'articles' => $articlesRepository->findAll(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/MentionsLegales", name="app_mentions_legales")
     */
    public function mentionslegales(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer)
    {
        return $this->render('static/legal.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
        ]);
    }

    /**
     * @Route("/PolitiqueConfidentialite", name="app_politique_confidentialite")
     */
    public function confidentialite(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer)
    {
        return $this->render('static/confid.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
        ]);
    }

    /**
     * @Route("/PolitiqueCookies", name="app_politique_cookies")
     */
    public function politiquecookies(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer)
    {
        return $this->render('static/cookies.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
        ]);
    }

    /**
     * @Route("/PlanSite", name="app_plan_site")
     */
    public function plansite(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer)
    {
        return $this->render('static/plansite.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
        ]);
    }

    /**
     * @Route("/Association/Benevoles", name="app_association_benevoles")
     */
    public function association_benevoles(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer)
    {
        return $this->render('default/association_benevoles.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
        ]);
    }

    /**
     * @Route("/Association/Demarches", name="app_association_demarches")
     */
    public function association_demarches(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer)
    {
        return $this->render('default/association_demarches.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
        ]);
    }

    /**
     * @Route("/Association/Partenaires", name="app_association_partenaires")
     */
    public function association_partenaires(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer, PartenairesRepository $partenairesRepository, EventsRepository $eventsRepository)
    {
        return $this->render('default/association_partenaires.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
            'partenaires' => $partenairesRepository->findAll(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/Documentation/Photothèque", name="app_doc_phototheque")
     */
    public function doc_phototheque(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer)
    {
        return $this->render('default/doc_phototheque.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
        ]);
    }
    /**
     * @Route("/Documentation/Archives", name="app_doc_archives")
     */
    public function index(ArticlesRepository $articlesRepository, Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer): Response
    {
        return $this->render('articles/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'form' => $this->contact($request, $mailer)->createView(),
        ]);
    }
    /*public function doc_archives(Environment $twigEnvironment)
    {
        return $this->render('default/doc_archives.html.twig');
    }*/
    /**
     * @Route("/Bibliothèque/Documentation", name="app_doc_documentation")
     */
    public function doc_documentation(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer,
                                      AteliersRepository $ateliersRepository, EventsRepository $eventsRepository)
    {
        return $this->render('default/doc_documentation.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/Site/Flore", name="app_site_flore")
     */
    public function site_flore(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer)
    {
        return $this->render('default/site_flore.html.twig', [
            'form' => $this->contact($request, $mailer)->createView(),
        ]);
    }

    public function contact(Request $request, \Swift_Mailer $mailer)
    {
      $form = $this->createForm(ContactType::class);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
        $nom = $form->get('nom')->getData();
        $email = $form->get('email')->getData();
        $messageVisiteur = $form->get('message')->getData();

        $message = (new \Swift_Message('Demande de contact'))
            ->setFrom($this->getParameter('mail'))
            ->setTo($this->getParameter('mail'))
            ->setBody(
                $this->renderView(
                    'emails/contact.html.twig',
                    ['nom' => $nom, 'email' => $email, 'message' => nl2br(htmlentities($messageVisiteur))]
                ),
                'text/html'
            );
        $mailer->send($message);
      }

      $form = $this->createForm(ContactType::class);

      return $form;
    }



}
