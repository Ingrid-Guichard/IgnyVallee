<?php

namespace App\Controller;


use App\Entity\Referents;
use App\Form\ReferentsType;
use App\Form\EventsType;
use App\Repository\ReferentsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ReferentsController extends AbstractController
{

    /* PARTIE GESTION PAR ADMINISTRATEURS */

    /* Pour la partie administrateur, intégré /admin en dur au début de chaque route
   - Chaque entité est écrite avec un -s dans les routes*/
    

    /**
     * @Route("/admin/referents", name="referents_index", methods={"GET"})
     */
    public function indexReferent(ReferentsRepository $referentsRepository): Response
    {
        return $this->render('referents/index.html.twig', [
            'referents' => $referentsRepository->findAll(),
        ]);
    }

    //    /**
//     * @Route("/admin/referents", name="referents_index", methods={"GET"})
//     */
//    public function indexReferent(AdherentsRepository $adherentsRepository): Response
//    {
//        return $this->render('referents/index.html.twig', [
//            'referents' => $adherentsRepository->findBy(array('isReferent' => true)),
//        ]);
//    }

    /**
     * @Route("/admin/referents/new", name="referents_new", methods={"GET","POST"})
     */
    public function newReferent(Request $request): Response
    {
        $referent = new Referents();
        $form = $this->createForm(ReferentsType::class, $referent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $referent->setHeuresGestionReferent(0);
            if (in_array(1,$referent->getActivites())) {
                $referent->getAdherent()->setIsReferentP(true);
            }
            if (in_array(2,$referent->getActivites())) {
                $referent->getAdherent()->setIsReferentR(true);
            }
            if (in_array(3,$referent->getActivites())) {
                $referent->getAdherent()->setIsReferentV(true);
            }
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($referent);
            $entityManager->flush();

            return $this->redirectToRoute('referents_index');
        }

        return $this->render('referents/new.html.twig', [
            'referent' => $referent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/referents/{id}", name="referents_show", methods={"GET"})
     */
    public function showReferent(Referents $referent): Response
    {
        return $this->render('referents/show.html.twig', [
            'referent' => $referent,
        ]);
    }

    /**
     * @Route("/admin/referents/{id}/edit", name="referents_edit", methods={"GET","POST"})
     */
    public function editReferent(Request $request, Referents $referent): Response
    {
        $form = $this->createForm(ReferentsType::class, $referent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('referents_index');
        }

        return $this->render('referents/edit.html.twig', [
            'referent' => $referent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/referents/{id}", name="referents_delete", methods={"DELETE"})
     */
    public function deleteReferent(Request $request, Referents $referent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$referent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($referent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('referents_index');
    }

    /* FIN DE LA PARTIE GESTION PAR ADMINISTRATEURS */

}