<?php

namespace App\Controller;

use App\Entity\Taches;
use App\Form\TachesType;
use App\Repository\TachesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/taches")
 */
class TachesController extends AbstractController
{
    /**
     * @Route("/", name="taches_index", methods={"GET"})
     */
    public function indexTaches(TachesRepository $tachesRepository): Response
    {
        return $this->render('taches/index.html.twig', [
            'taches' => $tachesRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="taches_new", methods={"GET","POST"})
     */
    public function newTaches(Request $request): Response
    {
        $tach = new Taches();
        $form = $this->createForm(TachesType::class, $tach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tach -> setIsDone(false);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($tach);
            $entityManager->flush();

            return $this->redirectToRoute('taches_index');
        }

        return $this->render('taches/new.html.twig', [
            'tach' => $tach,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="taches_edit", methods={"GET","POST"})
     */
    public function editTaches(Request $request, Taches $tach): Response
    {
        $form = $this->createForm(TachesType::class, $tach);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('taches_index');
        }

        return $this->render('taches/edit.html.twig', [
            'tach' => $tach,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="taches_delete", methods={"DELETE"})
     */
    public function deleteTaches(Request $request, Taches $tach): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tach->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($tach);
            $entityManager->flush();
        }

        return $this->redirectToRoute('taches_index');
    }
}
