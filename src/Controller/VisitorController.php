<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class VisitorController extends AbstractController
{
    /**
     * @Route("/default", name="app_visitorpage")
     */
    public function visitorpage(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer)
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
        return $this->render('default/homepage.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
