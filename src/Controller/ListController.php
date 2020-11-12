<?php

namespace App\Controller;

use App\Repository\AteliersRepository;
use App\Repository\EventsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function index(Request $request, AteliersRepository $ateliersRepository, EventsRepository $eventsRepository)
    {
        $BureauMembers = [
            'Président(e)' => 'Paul',
            'Vice-Président(e)' => 'Mathilde',
            'Vice-Président(e)' => 'Emmanuel',
            'Trésorier(e)' => 'Jean Guillaume',
            'Secrétaire' => 'Marguerite',
            'Référent Potager' => 'Françoise',
            'Référent Verger' => 'Guillaume',
            'Référent Rucher' => 'Delphine',
            'Responsable evenements' => 'Jean Pierre',
        ];

        return $this->render('list/index.html.twig', [
            'bureau_members' => $BureauMembers,
            'ateliersLast' => $ateliersRepository->getLastAteliers(new \DateTime('now')),
            'eventsLast' => $eventsRepository->getLastEvents(new \DateTime('now')),
        ]);
    }
}