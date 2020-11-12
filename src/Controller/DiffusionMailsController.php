<?php

namespace App\Controller;


use App\Repository\AdherentsRepository;
use App\Form\DiffusionMailsType;
use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Swift_Mailer;
use Swift_Message;
use swiftmailer;

/**
 * Require ROLE_REFERENT for *every* controller method in this class.
 *
 * @IsGranted("ROLE_REFERENT")
 *
 *
 */
class DiffusionMailsController extends AbstractController
{
    /**
     * @Route("/diffusion", name="diffusion_mails", methods={"GET","POST"})
     */
    public function diffusionMailsAdherent(Request $request, \Swift_Mailer $mailer, AdherentsRepository $adherentsRepository, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
      $form = $this->createForm(DiffusionMailsType::class);
      $form->handleRequest($request);

      if($form->isSubmitted() && $form->isValid()){
        $tousActifs = $form->get('tous')->getData();
        $admins = $form->get('administrateurs')->getData();
        $referents = $form->get('referent')->getData();
        $adhrentTous = $form->get('adherentTous')->getData();
        $adhrentP = $form->get('adherentP')->getData();
        $adhrentR = $form->get('adherentR')->getData();
        $adhrentV = $form->get('adherentV')->getData();
        $adhrentE = $form->get('adherentE')->getData();
        $adhrentCom = $form->get('adherentCom')->getData();
        $adhrentIntP = $form->get('adherentIntP')->getData();
        $adhrentIntR = $form->get('adherentIntR')->getData();
        $adhrentIntV = $form->get('adherentIntV')->getData();
        $adhrentIntE = $form->get('adherentIntE')->getData();
        $adhrentArchive = $form->get('adherentArchive')->getData();
        $object = $form->get('object')->getData();
        $messageADiffuser = $form->get('message')->getData();
        $annee = $form->get('annee')->getData();

        $listeDiffusion = [];
        if($annee == null){
          if($tousActifs == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByActif());
          }
          if($admins == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByIsAdmin());
          }
          if($referents == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByIsReferent());
          }
          if($adhrentTous == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByOnlyAdherent());
          }
          if($adhrentP == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActPotager());
          }
          if($adhrentR == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActRucher());
          }
          if($adhrentV == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActVerger());
          }
          if($adhrentE == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActAnimation());
          }
          if($adhrentCom == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActPromotion());
          }
          if($adhrentIntP == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentIntPotager());
          }
          if($adhrentIntR == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentIntRucher());
          }
          if($adhrentIntV == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentIntVerger());
          }
          if($adhrentIntE == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentIntAnimation());
          }
          if($adhrentArchive == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentArchive());
          }
        }else{
          if($tousActifs == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByActifByDate($annee));
          }
          if($admins == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByIsAdminByDate($annee));
          }
          if($referents == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByIsReferentByDate($annee));
          }
          if($adhrentTous == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByOnlyAdherentByDate($annee));
          }
          if($adhrentP == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActPotagerByDate($annee));
          }
          if($adhrentR == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActRucherByDate($annee));
          }
          if($adhrentV == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActVergerByDate($annee));
          }
          if($adhrentE == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActAnimationByDate($annee));
          }
          if($adhrentCom == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentActPromotionByDate($annee));
          }
          if($adhrentIntP == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentIntPotagerByDate($annee));
          }
          if($adhrentIntR == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentIntRucherByDate($annee));
          }
          if($adhrentIntV == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentIntVergerByDate($annee));
          }
          if($adhrentIntE == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentIntAnimationByDate($annee));
          }
          if($adhrentArchive == true){
            $listeDiffusion = array_merge($listeDiffusion, $adherentsRepository->findByAdherentArchiveByDate($annee));
          }
        }


        $listeEnvoie = array_unique($listeDiffusion, SORT_REGULAR);

        foreach ($listeEnvoie as $result) {
          $message = (new \Swift_Message($object))
              ->setFrom($this->getParameter('mail'))
              ->setTo($result->getEmail())
              ->setBody(
                  $this->renderView(
                      'emails/emailTemplateDiffusion.html.twig',
                      ['message' => nl2br(htmlentities($messageADiffuser))]
                  ),
                  'text/html'
              );
          $mailer->send($message);
        }



        return $this->redirectToRoute('app_homepage');
      }
        return $this->render('diffusionMails/diffusion_mails.html.twig', [
          'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }
}
