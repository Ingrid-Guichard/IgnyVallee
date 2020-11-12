<?php

namespace App\Controller;

use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Form\ContactType;
use swiftmailer;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repository\VergerActiviteSiteRepository;
use App\Repository\ImagesSiteRepository;
use App\Entity\ImagesSite;
use App\Form\ImagesSiteType;
use App\Entity\VergerActiviteSite;
use App\Form\VergerActiviteSiteType;


class VergerActiviteSiteController extends AbstractController
{

  /**
   * @Route("/Activite/Verger", name="app_activite_verger")
   */
  public function activite_verger(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer, ImagesSiteRepository $imagesSiteRepository,
                                  MainController $mainController, VergerActiviteSiteRepository $vergerActiviteSiteRepository, EventsRepository $eventsRepository)
  {
      $verger = $vergerActiviteSiteRepository->findAll();
      foreach ($verger as $v)
      {
          $idVergerActiviteSite = $v->getId();
          $titre = $v->getTitre();
          $description = $v->getDescription();
      }
      return $this->render('default/activite_verger.html.twig', [
        'form' => $mainController->contact($request, $mailer)->createView(),
        'titre' => $titre,
        'description' => nl2br(htmlentities($description)),
        'idVergerActiviteSite' =>$idVergerActiviteSite,
        'images' => $imagesSiteRepository->findBySecteurByActive('VergerActivite'),
          'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
    ]);
  }

    /**
     * @Route("/admin/Activite/Verger/newImage", name="activite_verger_newImage", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
        $image = new ImagesSite();
        $form = $this->createForm(ImagesSiteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $imageFile = $form->get('imageName')->getData();
          if($imageFile){
            $originalImageName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeImageName = $slugger->slug($originalImageName);
            $newImageName = $safeImageName.'-'.uniqid().'.'.$imageFile->guessExtension();
            try{
              $imageFile->move(
                $this->getParameter('images_activite_Verger_directory'),
                $newImageName
              );
            }catch(FileException $e){
              // ... handle exception if something happens during file upload
            }
            $image->setNom($newImageName);
          }
            $image->setPageRelative('VergerActivite');
            $image->setActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_verger');
        }

        return $this->render('vergerActiviteSite/new.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/Verger/Image/{id}/edit", name="activite_verger_editImage", methods={"GET","POST"})
     */
    public function editImage(Request $request, SluggerInterface $slugger, ImagesSite $image,
                              EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
      $form = $this->createForm(ImagesSiteType::class);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $imageFile = $form->get('imageName')->getData();
        if($imageFile){
          $originalImageName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
          $safeImageName = $slugger->slug($originalImageName);
          $newImageName = $safeImageName.'-'.uniqid().'.'.$imageFile->guessExtension();
          try{
            $imageFile->move(
              $this->getParameter('images_activite_Verger_directory'),
              $newImageName
            );
          }catch(FileException $e){
            // ... handle exception if something happens during file upload
          }
          $image->setNom($newImageName);
        }
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($image);
          $entityManager->flush();

          return $this->redirectToRoute('app_activite_verger');
      }

        return $this->render('vergerActiviteSite/editImage.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/Verger/Delete/{id}", name="activite_verger_deleteImage", methods={"DELETE"})
     */
    public function delete(Request $request, ImagesSite $imagesSites): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagesSites->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $imagesSites->setActive(false);
            $entityManager->persist($imagesSites);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activite_verger');
    }

    /**
     * @Route("/admin/Activite/Verger/{id}/edit", name="activite_verger_editPage", methods={"GET","POST"})
     */
    public function editPage(Request $request, SluggerInterface $slugger, VergerActiviteSite $verger,
                             EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
      $form = $this->createForm(VergerActiviteSiteType::class, $verger);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($verger);
          $entityManager->flush();

          return $this->redirectToRoute('app_activite_verger');
      }

        return $this->render('vergerActiviteSite/editPage.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

}
