<?php

namespace App\Form;

use App\Entity\Activites;
use App\Entity\Adherents;
use App\Entity\Referents;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReferentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('adherent', EntityType::class, [
                'class' => Adherents::class,
                'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('a')
                    ->orderBy('a.nom','ASC');
                },
                'choice_label' => 'nom',
            ])
            ->add('activites', EntityType::class, [
                'class' => Activites::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'nom',
            ]);

        //Retirés : heuresGestionReferent, ateliers
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Referents::class,
        ]);
    }
}
