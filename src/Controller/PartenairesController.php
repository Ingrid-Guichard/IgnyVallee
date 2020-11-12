<?php

namespace App\Controller;

use App\Entity\Partenaires;
use App\Form\PartenairesType;
use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use App\Repository\PartenairesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;


/**
 * @Route("/partenaires")
 */
class PartenairesController extends AbstractController
{
    /**
     * @Route("/", name="partenaires_index", methods={"GET"})
     */
    public function index(PartenairesRepository $partenairesRepository, EventsRepository $eventsRepository): Response
    {
        return $this->render('partenaires/index.html.twig', [
            'partenaires' => $partenairesRepository->findAll(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/new", name="partenaires_new", methods={"GET","POST"})
     */
    public function new(Request $request, SluggerInterface $slugger, EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
        $partenaire = new Partenaires();
        $form = $this->createForm(PartenairesType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $imageFile = $form->get('imageName')->getData();
          if($imageFile){
            $originalImageName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeImageName = $slugger->slug($originalImageName);
            $newImageName = $safeImageName.'-'.uniqid().'.'.$imageFile->guessExtension();
            try{
              $imageFile->move(
                $this->getParameter('images_partenaires_directory'),
                $newImageName
              );
            }catch(FileException $e){
              // ... handle exception if something happens during file upload
            }
            $partenaire->setImageName($newImageName);
          }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partenaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_association_partenaires');
        }

        return $this->render('partenaires/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/{id}", name="partenaires_show", methods={"GET"})
     */
    public function show(Partenaires $partenaire, EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
        return $this->render('partenaires/show.html.twig', [
            'partenaire' => $partenaire,
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="partenaires_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Partenaires $partenaire, SluggerInterface $slugger,
                         EventsRepository $eventsRepository, AteliersRepository $ateliersRepository): Response
    {
        $form = $this->createForm(PartenairesType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
          $imageFile = $form->get('imageName')->getData();
          if($imageFile){
            $originalImageName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeImageName = $slugger->slug($originalImageName);
            $newImageName = $safeImageName.'-'.uniqid().'.'.$imageFile->guessExtension();
            try{
              $imageFile->move(
                $this->getParameter('images_partenaires_directory'),
                $newImageName
              );
            }catch(FileException $e){
              // ... handle exception if something happens during file upload
            }
            $partenaire->setImageName($newImageName);
          }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($partenaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_association_partenaires');
        }

        return $this->render('partenaires/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form->createView(),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/{id}", name="partenaires_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Partenaires $partenaire): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partenaire->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($partenaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_association_partenaires');
    }
}
