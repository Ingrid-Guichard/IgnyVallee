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
use App\Repository\HistoireRepository;
use App\Repository\ImagesSiteRepository;
use App\Entity\ImagesSite;
use App\Form\ImagesSiteType;
use App\Entity\Histoire;
use App\Form\HistoireType;


class AssociationHistoireController extends AbstractController
{
    /**
     * @Route("/Association/Histoire", name="app_association_histoire")
     */
    public function association_histoire(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer,
                                         HistoireRepository $histoireRepository, ImagesSiteRepository $imagesSiteRepository,
                                         MainController $mainController, EventsRepository $eventsRepository)
    {
      $histoire = $histoireRepository->findAll();
      foreach ($histoire as $his)
      {
          $idHistoire = $his->getId();
          $titre = $his->getTitre();
          $description = $his->getDescription();
      }
        return $this->render('default/association_histoire.html.twig', [
            'form' => $mainController->contact($request, $mailer)->createView(),
            'titre' => $titre,
            'description' => nl2br(htmlentities($description)),
            'idHistoire' =>$idHistoire,
            'images' => $imagesSiteRepository->findBySecteurByActive('Histoire'),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Association/Histoire/newImage", name="histoire_newImage", methods={"GET","POST"})
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
                $this->getParameter('images_histoire_directory'),
                $newImageName
              );
            }catch(FileException $e){
              // ... handle exception if something happens during file upload
            }
            $image->setNom($newImageName);
          }
            $image->setPageRelative('Histoire');
            $image->setActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_association_histoire');
        }

        return $this->render('histoire/new.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Association/Histoire/Image/{id}/edit", name="histoire_editImage", methods={"GET","POST"})
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
              $this->getParameter('images_histoire_directory'),
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

          return $this->redirectToRoute('app_association_histoire');
      }

        return $this->render('histoire/editImage.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Association/Histoire/Delete/{id}", name="histoire_deleteImage", methods={"DELETE"})
     */
    public function delete(Request $request, ImagesSite $imagesSites): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagesSites->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $imagesSites->setActive(false);
            $entityManager->persist($imagesSites);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_association_histoire');
    }

    /**
     * @Route("/admin/Association/Histoire/{id}/edit", name="histoire_editPage", methods={"GET","POST"})
     */
    public function editPageHistoire(Request $request, SluggerInterface $slugger, Histoire $histoire,
                                     EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
      $form = $this->createForm(HistoireType::class, $histoire);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($histoire);
          $entityManager->flush();

          return $this->redirectToRoute('app_association_histoire');
      }

        return $this->render('histoire/editPageHistoire.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

}
