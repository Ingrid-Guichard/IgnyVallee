<?php

namespace App\Form;

use App\Entity\Adherents;
use App\Entity\Admins;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminsType extends AbstractType
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
        ;

        //Retirés : heuresGestionAdmin, events
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Admins::class,
        ]);
    }
}
