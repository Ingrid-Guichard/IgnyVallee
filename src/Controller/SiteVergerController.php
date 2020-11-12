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
use App\Repository\VergerSiteRepository;
use App\Repository\ImagesSiteRepository;
use App\Entity\ImagesSite;
use App\Form\ImagesSiteType;
use App\Entity\VergerSite;
use App\Form\SiteVergerType;


class SiteVergerController extends AbstractController
{
  /**
   * @Route("/Site/Verger", name="app_site_verger")
   */
  public function site_verger(Environment $twigEnvironment, Request $request, \Swift_Mailer $mailer, MainController $mainController,
                              VergerSiteRepository $vergerSiteRepository, ImagesSiteRepository $imagesSiteRepository, EventsRepository $eventsRepository)
  {
    $verger = $vergerSiteRepository->findAll();
    foreach ($verger as $v)
    {
        $idVerger = $v->getId();
        $titre = $v->getTitre();
        $description = $v->getDescription();
    }
      return $this->render('default/site_verger.html.twig', [
          'form' => $mainController->contact($request, $mailer)->createView(),
          'titre' => $titre,
          'description' => nl2br(htmlentities($description)),
          'idVerger' =>$idVerger,
          'images' => $imagesSiteRepository->findBySecteurByActive('SiteVerger'),
          'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
      ]);
  }

    /**
     * @Route("/admin/Site/Verger/newImage", name="site_verger_newImage", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger , EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
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
                $this->getParameter('images_site_verger_directory'),
                $newImageName
              );
            }catch(FileException $e){
              // ... handle exception if something happens during file upload
            }
            $image->setNom($newImageName);
          }
            $image->setPageRelative('SiteVerger');
            $image->setActive(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('app_site_verger');
        }

        return $this->render('vergerSite/new.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Site/Verger/Image/{id}/edit", name="site_verger_editImage", methods={"GET","POST"})
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
              $this->getParameter('images_site_verger_directory'),
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

          return $this->redirectToRoute('app_site_verger');
      }

        return $this->render('vergerSite/editImage.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/admin/Site/Verger/Delete/{id}", name="site_verger_deleteImage", methods={"DELETE"})
     */
    public function delete(Request $request, ImagesSite $imagesSites): Response
    {
        if ($this->isCsrfTokenValid('delete'.$imagesSites->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $imagesSites->setActive(false);
            $entityManager->persist($imagesSites);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_site_verger');
    }

    /**
     * @Route("/admin/Site/Verger/{id}/edit", name="site_verger_editPage", methods={"GET","POST"})
     */
    public function editPageSiteVerger(Request $request, SluggerInterface $slugger, VergerSite $vergerSite,
                                       EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
      $form = $this->createForm(SiteVergerType::class, $vergerSite);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->persist($vergerSite);
          $entityManager->flush();

          return $this->redirectToRoute('app_site_verger');
      }

        return $this->render('vergerSite/editPageSiteVerger.html.twig', [
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

}
