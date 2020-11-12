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
use App\Repository\AnimationRepository;
use App\Repository\ImagesSiteRepository;
use App\Entity\ImagesSite;
use App\Form\ImagesSiteType;
use App\Entity\Animation;
use App\Form\AnimationType;


class AnimationController extends AbstractController
{
    /**
     * @Route("/Activite/VieAssociative", name="app_activite_vie_asso")
     */
    public function vieasso(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer, AnimationRepository $animationRepository,
                            ImagesSiteRepository $imagesSiteRepository, MainController $mainController, EventsRepository $eventsRepository)
    {
      $animation = $animationRepository->findAll();
      foreach ($animation as $a)
      {
          $idAnimation = $a->getId();
          $titre = $a->getTitre();
          $description = $a->getDescription();
      }
        return $this->render('default/activite_vie_asso.html.twig', [
            'form' => $mainController->contact($request, $mailer)->createView(),
            'titre' => $titre,
            'description' => nl2br(htmlentities($description)),
            'idAnimation' =>$idAnimation,
            'images' => $imagesSiteRepository->findBySecteurByActive('Animation'),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/VieAssociative/newImage", name="activite_vie_asso_newImage", methods={"GET","POST"})
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
                $this->getParameter('images_activite_animation_directory'),
                $newImageName
              );
            }catch(FileException $e){
              // ... handle exception if something happens during file upload
            }
            $image->setNom($newImageName);
          }
            $image->setPageRelative('Animation');
            $image->setActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_vie_asso');
        }

        return $this->render('animation/new.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/VieAssociative/Image/{id}/edit", name="activite_vie_asso_editImage", methods={"GET","POST"})
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
              $this->getParameter('images_activite_animation_directory'),
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

          return $this->redirectToRoute('app_activite_vie_asso');
      }

        return $this->render('animation/editImage.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/VieAssociative/Delete/{id}", name="activite_vie_asso_deleteImage", methods={"DELETE"})
     */
    public function delete(Request $request, ImagesSite $imagesSites): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagesSites->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $imagesSites->setActive(false);
            $entityManager->persist($imagesSites);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activite_vie_asso');
    }

    /**
     * @Route("/admin/Activite/VieAssociative/{id}/edit", name="activite_vie_asso_editPage", methods={"GET","POST"})
     */
    public function editPage(Request $request, SluggerInterface $slugger, Animation $animation,
                             EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
      $form = $this->createForm(AnimationType::class, $animation);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($animation);
          $entityManager->flush();

          return $this->redirectToRoute('app_activite_vie_asso');
      }

        return $this->render('animation/editPageAnimation.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

}
