<?php

namespace App\Controller;

use App\Entity\Admins;
use App\Form\AdminsType;
use App\Repository\AdminsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admins")
 */
class AdminsController extends AbstractController
{
    /**
     * @Route("/", name="admins_index", methods={"GET"})
     */
    public function index(AdminsRepository $adminsRepository): Response
    {
        return $this->render('admins/index.html.twig', [
            'admins' => $adminsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admins_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $admin = new Admins();
        $form = $this->createForm(AdminsType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $admin->setHeuresGestionAdmin(0);
            $admin->getAdherent()->setIsAdmin(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);
            $entityManager->flush();

            return $this->redirectToRoute('admins_index');
        }

        return $this->render('admins/new.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admins_show", methods={"GET"})
     */
    public function show(Admins $admin): Response
    {
        return $this->render('admins/show.html.twig', [
            'admin' => $admin,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admins_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Admins $admin): Response
    {
        $form = $this->createForm(AdminsType::class, $admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admins_index');
        }

        return $this->render('admins/edit.html.twig', [
            'admin' => $admin,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="admins_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Admins $admin): Response
    {
        if ($this->isCsrfTokenValid('delete'.$admin->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($admin);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admins_index');
    }
}
