<?php

namespace App\Controller;

use App\Entity\Adherents;
use App\Form\UserType;
use App\Repository\ActivitesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use swiftmailer;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request, \Swift_Mailer $mailer, ActivitesRepository $activiteRepository)
    {
        $user = new Adherents();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            // Set their role
            $user->setRoles(['ROLE_USER']);
            $prenom = $form->get('prenom')->getData();
            $email = $form->get('email')->getData();
            $nom = $form->get('nom')->getData();
            $potager = $form->get('isActPotager')->getData();
            if ($potager == true) {
                $activite = $activiteRepository->find(1);
                $user->addActivite($activite);
            }
            $verger = $form->get('isActVerger')->getData();
            if ($verger == true) {
                $activite = $activiteRepository->find(3);
                $user->addActivite($activite);
            }
            $rucher = $form->get('isActRucher')->getData();
            if ($rucher == true) {
                $activite = $activiteRepository->find(2);
                $user->addActivite($activite);
            }
            $dateAdhesion = (new \DateTime);
            $user->setDebutAdhesion((new \DateTime));
            $user->setFinAdhesion($dateAdhesion
                ->modify('+1 year')); // il fautdrait seulement posséder un champ pour l'année en cours
            $user->setIsPayed(false);
            $user->setIsAdmin(false);
            $user->setIsReferentP(false);
            $user->setIsReferentR(false);
            $user->setIsReferentV(false);

            $user->setIsArchive(false);
            $user->setValide(false);
            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $message = (new \Swift_Message('Nouvelle adhésion à l\'association Igny Vallée Comestible'))
                ->setFrom($this->getParameter('mail'))
                ->setTo($email)
                ->setBody(
                    $this->renderView(
                        'emails/ajoutAdhByAdmin.html.twig',
                        ['prenom' => $prenom, 'nom' => $nom, 'email' => $email, 'mdp' => 'celui que vous avez défini', 'status' => 'votre compte doit être validé avant d\'être actif']
                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
