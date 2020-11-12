<?php

namespace App\Controller;

use App\Entity\Activites;
use App\Entity\Ruchers;
use App\Form\FiltresRucherType;
use App\Form\RuchersType;
use App\Repository\ActivitesRepository;
use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use App\Repository\RuchersRepository;
use App\Repository\RuchesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADHERENT")
 * @Route("/ruchers")
 */
class RuchersController extends AbstractController
{
    /**
     *
     * @Route("/", name="ruchers_index", methods={"GET", "POST"})
     */
    public function index(Request $request, RuchersRepository $ruchersRepository, AteliersRepository $ateliersRepository): Response
    {
        $form = $this->createForm(FiltresRucherType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $nom = $form->get('nom')->getData();
            $date = $form->get('date')->getData();

            $listeRuchers = [];
            if ($nom != null && $date == null) {
                $listeRuchers = array_merge($listeRuchers, $ruchersRepository->findByNom($nom));
            }
            if ($nom == null && $date != null) {
                $listeRuchers = array_merge($listeRuchers, $ruchersRepository->findByDate($date));
            }
            if ($nom != null && $date != null) {
                $listeRuchers = array_merge($listeRuchers, $ruchersRepository->getByNomByDate($date, $nom));
            }
            if ($nom == null && $date == null) {
                $listeRuchers = array_merge($listeRuchers, $ruchersRepository->findBy(
                    array(),
                    array('nomRucher' => 'ASC')
                ));
            }
            $listeRuchersFinal = array_unique($listeRuchers, SORT_REGULAR);
            $form = $this->createForm(FiltresRucherType::class);

            return $this->render('ruchers/index.html.twig', [
                'form' => $form->createView(),
                'ruchers' => $listeRuchersFinal,
                'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            ]);
        }

        return $this->render('ruchers/index.html.twig', [
            'form' => $form->createView(),
            'ruchers' => $ruchersRepository->findBy(
                array(),
                array('nomRucher' => 'ASC')
            ),

            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/new", name="ruchers_new", methods={"GET","POST"})
     */
    public function new(Request $request, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository, ActivitesRepository $activitesRepository): Response
    {
        $rucher = new Ruchers();
        $form = $this->createForm(RuchersType::class, $rucher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $activite = $activitesRepository -> find(2);
            $rucher -> setActivite($activite);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rucher);
            $entityManager->flush();

            return $this->redirectToRoute('ruchers_index');
        }

        return $this->render('ruchers/new.html.twig', [
            'rucher' => $rucher,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/{id}", name="ruchers_show", methods={"GET"})
     */
    public function show(Ruchers $rucher, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository, RuchesRepository $ruchesRepository): Response
    {
        return $this->render('ruchers/show.html.twig', [
            'rucher' => $rucher,
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/{id}/ruches", name="ruchers_show_ruches", methods={"GET"})
     */
    public function showRuches(Ruchers $rucher, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository, RuchesRepository $ruchesRepository): Response
    {
        return $this->render('ruchers/indexByRucher.html.twig', [
            'rucher' => $rucher,
            'ruches' => $ruchesRepository -> findByRucher($rucher),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/{id}/edit", name="ruchers_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Ruchers $rucher, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $form = $this->createForm(RuchersType::class, $rucher);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ruchers_index');
        }

        return $this->render('ruchers/edit.html.twig', [
            'rucher' => $rucher,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_REFERENT")
     * @Route("/{id}", name="ruchers_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Ruchers $rucher): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rucher->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rucher);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ruchers_index');
    }
}
