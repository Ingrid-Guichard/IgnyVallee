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
use App\Repository\JardinRepository;
use App\Repository\ImagesSiteRepository;
use App\Entity\ImagesSite;
use App\Form\ImagesSiteType;
use App\Entity\Jardin;
use App\Form\JardinType;


class JardinController extends AbstractController
{
    /**
     * @Route("/Activite/JardinPermacole", name="app_activite_jardin")
     */
    public function vieasso(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer, JardinRepository $JardinRepository, ImagesSiteRepository $imagesSiteRepository, MainController $mainController, EventsRepository $eventsRepository)
    {
      $Jardin = $JardinRepository->findAll();
      foreach ($Jardin as $a)
      {
          $idJardin = $a->getId();
          $titre = $a->getTitre();
          $description = $a->getDescription();
      }
        return $this->render('default/activite_jardin.html.twig', [
            'form' => $mainController->contact($request, $mailer)->createView(),
            'titre' => $titre,
            'description' => nl2br(htmlentities($description)),
            'idJardin' =>$idJardin,
            'images' => $imagesSiteRepository->findBySecteurByActive('Jardin'),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/JardinPermacole/newImage", name="activite_jardin_newImage", methods={"GET","POST"})
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
                $this->getParameter('images_activite_jardin_directory'),
                $newImageName
              );
            }catch(FileException $e){
              // ... handle exception if something happens during file upload
            }
            $image->setNom($newImageName);
          }
            $image->setPageRelative('Jardin');
            $image->setActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_activite_jardin');
        }

        return $this->render('jardin/new.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/JardinPermacole/Image/{id}/edit", name="activite_jardin_editImage", methods={"GET","POST"})
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
              $this->getParameter('images_activite_jardin_directory'),
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

          return $this->redirectToRoute('app_activite_jardin');
      }

        return $this->render('jardin/editImage.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Activite/JardinPermacole/Delete/{id}", name="activite_jardin_deleteImage", methods={"DELETE"})
     */
    public function delete(Request $request, ImagesSite $imagesSites): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagesSites->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $imagesSites->setActive(false);
            $entityManager->persist($imagesSites);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_activite_jardin');
    }

    /**
     * @Route("/admin/Activite/JardinPermacole/{id}/edit", name="activite_jardin_editPage", methods={"GET","POST"})
     */
    public function editPage(Request $request, SluggerInterface $slugger, Jardin $Jardin,
                             EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
      $form = $this->createForm(JardinType::class, $Jardin);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($Jardin);
          $entityManager->flush();

          return $this->redirectToRoute('app_activite_jardin');
      }

        return $this->render('jardin/editPage.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

}
