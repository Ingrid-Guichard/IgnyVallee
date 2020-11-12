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
use App\Repository\RucheActiviteSiteRepository;
use App\Repository\ImagesSiteRepository;
use App\Entity\ImagesSite;
use App\Form\ImagesSiteType;
use App\Entity\RucheActiviteSite;
use App\Form\RucheActiviteSiteType;


class RucherActiviteSiteController extends AbstractController
{
    /**
     * @Route("/Activite/RucherPedagogique", name="app_activite_rucher")
     */
    public function rucherpeda(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer, RucheActiviteSiteRepository $rucheActiviteSiteRepository,
                               ImagesSiteRepository $imagesSiteRepository, MainController $mainController, EventsRepository $eventsRepository)
    {
      $rucher = $rucheActiviteSiteRepository->findAll();
      foreach ($rucher as $r)
      {
          $idRucher = $r->getId();
          $titre = $r->getTitre();
          $description = $r->getDescription();
      }
        return $this->render('default/activite_rucher.html.twig', [
            'form' => $mainController->contact($request, $mailer)->createView(),
            'titre' => $titre,
            'description' => nl2br(htmlentities($description)),
            'idRucher' =>$idRucher,
            'images' => $imagesSiteRepository->findBySecteurByActive('Rucher'),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/RucherPedagogique/newImage", name="activite_rucher_newImage", methods={"GET","POST"})
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
                $this->getParameter('images_activite_rucher_directory'),
                $newImageName
              );
            }catch(FileException $e){
              // ... handle exception if something happens during file upload
            }
            $image->setNom($newImageName);
          }
            $image->setPageRelative('Rucher');
            $image->setActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_rucher');
        }

        return $this->render('rucherActiviteSite/new.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/RucherPedagogique/Image/{id}/edit", name="activite_rucher_editImage", methods={"GET","POST"})
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
              $this->getParameter('images_activite_rucher_directory'),
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

          return $this->redirectToRoute('app_activite_rucher');
      }

        return $this->render('rucherActiviteSite/editImage.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/RucherPedagogique/Delete/{id}", name="activite_rucher_deleteImage", methods={"DELETE"})
     */
    public function delete(Request $request, ImagesSite $imagesSites): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagesSites->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $imagesSites->setActive(false);
            $entityManager->persist($imagesSites);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activite_rucher');
    }

    /**
     * @Route("/admin/Activite/RucherPedagogique/{id}/edit", name="activite_rucher_editPage", methods={"GET","POST"})
     */
    public function editPage(Request $request, SluggerInterface $slugger, RucheActiviteSite $rucher,
                             EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
      $form = $this->createForm(RucheActiviteSiteType::class, $rucher);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($rucher);
          $entityManager->flush();

          return $this->redirectToRoute('app_activite_rucher');
      }

        return $this->render('rucherActiviteSite/editPage.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

}
