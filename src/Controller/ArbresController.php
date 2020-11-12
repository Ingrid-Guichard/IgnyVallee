<?php

namespace App\Controller;

use App\Entity\Arbres;
use App\Form\EditArbresAdherentType;
use App\Form\FiltresArbreType;
use App\Form\NewArbresType;
use App\Form\EditArbresType;
use App\Form\ValideParrainageType;
use App\Form\RefusParrainageType;
use App\Form\DemandeParrainageType;
use App\Repository\ArbresRepository;
use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;

class ArbresController extends AbstractController
{
    /**
     * @Route("/arbres", name="arbres_index", methods={"GET","POST"})
     * @IsGranted("ROLE_ADHERENT")
     */
    public function indexArbres(ArbresRepository $arbresRepository, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository, Request $request): Response
    {
        $form = $this->createForm(FiltresArbreType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $num = $form->get('num')->getData();
            $adherent = $form->get('adherent')->getData();


            $user = $this->security->getUser();


            $listeArbres = [];
            if ($num != null && $adherent == false) {
                $listeArbres = array_merge($listeArbres, $arbresRepository->findBynumeroArbre($num));
            }
            if ($num != null && $adherent == true) {
                $listeArbres = array_merge($listeArbres, $arbresRepository->getBynumeroArbreByAdherent($num, $user));
            }
            if ($num == null && $adherent == true) {
                $listeArbres = array_merge($listeArbres, $arbresRepository->findByAdherent($user));
            }
            if ($num == null && $adherent == false) {
                $listeArbres = array_merge($listeArbres, $arbresRepository->findAll());
            }

            $listeArbresFinal = array_unique($listeArbres, SORT_REGULAR);
            $form = $this->createForm(FiltresArbreType::class);

            return $this->render('arbres/index.html.twig', [
                'form' => $form->createView(),
                'arbres' => $listeArbresFinal,
                'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            ]);
        }

        return $this->render('arbres/index.html.twig', [
            'form' => $form->createView(),
            'arbres' => $arbresRepository->findAll(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
    }

    /**
     * @IsGranted("ROLE_ADHERENT")
     * @Route("/arbres/excel", name="arbres_index_excel", methods={"GET","POST"})
     */
    public function indexAdherentExcel(ArbresRepository $arbresRepository): Response
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();
        $liste = $arbresRepository->findAll();

        $sheet->setCellValueByColumnAndRow(1,1,'Numéro');
        $sheet->setCellValueByColumnAndRow(2,1,'Fruit');
        $sheet->setCellValueByColumnAndRow(3,1,'Parrain');
        $sheet->setCellValueByColumnAndRow(4,1,'Etat');
        $sheet->setCellValueByColumnAndRow(5,1,'Age');

        for($i = 0; $i < count($liste); ++$i) {
            $sheet->setCellValueByColumnAndRow(1,$i + 2,$liste[$i]->getNumeroArbre());
            $sheet->setCellValueByColumnAndRow(2,$i + 2,$liste[$i]->getNomFruitArbre());
            if ($liste[$i]->getAdherent() == null) {
                $sheet->setCellValueByColumnAndRow(3,$i + 2,'Libre');

            } else {
                $sheet->setCellValueByColumnAndRow(3,$i + 2,"{$liste[$i]->getAdherent()->getPrenom()} {$liste[$i]->getAdherent()->getNom()} ({$liste[$i]->getAdherent()->getId()})");
            }
            $sheet->setCellValueByColumnAndRow(4,$i + 2,$liste[$i]->getEtatArbre());
            $sheet->setCellValueByColumnAndRow(4,$i + 2,$liste[$i]->getAgeArbre());
        }

        $sheet->setTitle("Index des arbres");

        $writer = new Xlsx($spreadsheet);

        $fileName = 'index_arbres.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        // Create the excel file in the tmp directory of the system
        $writer->save($temp_file);

        // Return the excel file as an attachment
        return $this->file($temp_file, $fileName, ResponseHeaderBag::DISPOSITION_INLINE);
    }

    /**
     * @Route("/arbres/parrainer/valide", name="arbres_a_valider_index", methods={"GET","POST"})
     * @IsGranted("ROLE_REFERENT")
     */
    public function indexValideArbres(ArbresRepository $arbresRepository, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository, Request $request): Response
    {

        return $this->render('arbres/index.html.twig', [
            'arbres' => $arbresRepository->findByParrainageValide(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/arbres/new", name="arbres_new", methods={"GET","POST"})
     * @IsGranted("ROLE_REFERENT")
     */
    public function newArbres(Request $request, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $arbre = new Arbres();
        $form = $this->createForm(NewArbresType::class, $arbre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($arbre);
            $entityManager->flush();

            return $this->redirectToRoute('arbres_index');
        }

        return $this->render('arbres/new.html.twig', [
            'arbre' => $arbre,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/arbres/parrainer/valide/{id}", name="arbres_valide_parrainer", methods={"GET","POST"})
     * @IsGranted("ROLE_REFERENT")
     */
    public function parrainerValideArbres(Request $request, Arbres $arbre, AteliersRepository $ateliersRepository, ArbresRepository $arbresRepository, EventsRepository $eventsRepository): Response
    {
      $formValide = $this->createForm(ValideParrainageType::class, $arbre);
      $formValide->handleRequest($request);

      $formRefus = $this->createForm(RefusParrainageType::class, $arbre);
      $formRefus->handleRequest($request);

      if($formValide->isSubmitted() && $formValide->isValid()){
        $arbre->setParrainageValide(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($arbre);
        $entityManager->flush();
        return $this->render('arbres/index.html.twig', [
            'arbres' => $arbresRepository->findByParrainageValide(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
      }

      if($formRefus->isSubmitted() && $formRefus->isValid()){
        $arbre->setParrainageValide(null);
        $adherent = $arbre->getAdherent();
        $adherent-> removeArbre($arbre);
        $arbre->setAdherent(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($arbre);
        $entityManager->persist($adherent);
        $entityManager->flush();
        return $this->render('arbres/index.html.twig', [
            'arbres' => $arbresRepository->findByParrainageValide(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
      }

        return $this->render('arbres/show.html.twig', [
            'arbre' => $arbre,
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'formValide' =>  $formValide->createView(),
            'formRefus' =>  $formRefus->createView()
        ]);
    }

    /**
     * @Route("/arbres/{id}", name="arbres_show", methods={"GET","POST"})
     * @IsGranted("ROLE_ADHERENT")
     */
    public function showArbres(Request $request, Arbres $arbre, AteliersRepository $ateliersRepository, ArbresRepository $arbresRepository, EventsRepository $eventsRepository): Response
    {
      $formParrainage = $this->createForm(DemandeParrainageType::class, $arbre);
      $formParrainage->handleRequest($request);
      $formFiltres = $this->createForm(FiltresArbreType::class);
      $formFiltres->handleRequest($request);

      if($formParrainage->isSubmitted() && $formParrainage->isValid()){
        $arbre->setParrainageValide(false);
        $adherent = $this->security->getUser();
        $arbre->setAdherent($adherent);
        $adherent->addArbre($arbre);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($arbre);
        $entityManager->persist($adherent);
        $entityManager->flush();
        return $this->render('arbres/index.html.twig', [
            'form' => $formFiltres->createView(),
            'arbres' => $arbresRepository->findAll(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
        ]);
      }
        return $this->render('arbres/show.html.twig', [
            'arbre' => $arbre,
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
            'form' =>  $formParrainage->createView(),
        ]);
    }

    /**
     * @Route("/arbres/{id}/edit", name="arbres_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADHERENT")
     */
    public function editArbresbyAdmin(Request $request, Arbres $arbre, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository): Response
    {
        $adArbre = $arbre->getAdherent();
        $form = $this->createForm(EditArbresType::class, $arbre);
        $form->handleRequest($request);

        $parrain = $form->get('adherent')->getData();
        $adherent = $this->security->getUser();

        if ($parrain == $adherent || $adherent-> getIsAdmin() == true) {
            if ($form->isSubmitted() && $form->isValid()) {
              $parrainNew = $form->get('adherent')->getData();
                if($parrainNew == null && $adArbre == null){
                  $arbre->setParrainageValide(null);
                  $arbre->setAdherent(null);
                  $entityManager = $this->getDoctrine()->getManager();
                  $entityManager->persist($arbre);
                  $entityManager->persist($adherent);
                  $entityManager->flush();
                }else if($parrainNew == null && $adArbre != null){
                  $arbre->setParrainageValide(null);
                  $adArbre-> removeArbre($arbre);
                  $arbre->setAdherent(null);
                  $entityManager = $this->getDoctrine()->getManager();
                  $entityManager->persist($arbre);
                  $entityManager->persist($adherent);
                  $entityManager->flush();
                }else if ($adArbre == null && $parrainNew =! null){
                  $arbre->setParrainageValide(true);
                  $arbre->setAdherent($parrain);
                  $parrain->addArbre($arbre);
                  $entityManager = $this->getDoctrine()->getManager();
                  $entityManager->persist($arbre);
                  $entityManager->persist($parrain);
                  $entityManager->flush();
                }else if($parrainNew != $adArbre && $adArbre != null){
                  $arbre->setParrainageValide(true);
                  $adArbre-> removeArbre($arbre);
                  $arbre->setAdherent($parrain);
                  $parrain->addArbre($arbre);
                  $entityManager = $this->getDoctrine()->getManager();
                  $entityManager->persist($arbre);
                  $entityManager->persist($adherent);
                  $entityManager->persist($parrain);
                  $entityManager->flush();
                }
                return $this->redirectToRoute('arbres_index');
            }
        }

        return $this->render('arbres/edit.html.twig', [
            'arbre' => $arbre,
            'form' => $form->createView(),
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }

    /**
     * @Route("/arbres/{id}", name="arbres_delete", methods={"DELETE"})
     * @IsGranted("ROLE_REFERENT")
     */
    public function deleteArbres(Request $request, Arbres $arbre): Response
    {
        if ($this->isCsrfTokenValid('delete'.$arbre->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($arbre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('arbres_index');
    }

    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }
}
