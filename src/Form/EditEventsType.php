<?php

namespace App\Form;

use App\Entity\Admins;
use App\Entity\Events;
use App\Entity\Partenaires;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditEventsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateDebut', DateTimeType::class, [
            'view_timezone' => 'Europe/Paris'
            ])
            ->add('dateFin', DateTimeType::class)
            ->add('prix')
            ->add('description')
            ->add('partenaire', EntityType::class, [
                'required' => false,
                'class' => Partenaires::class,
                'choice_label' => 'nom',
            ])
            ->add('admins', EntityType::class, [
                'required' => false,
                'class' =>Admins::class,
                'choice_label' => 'adherent.prenom',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Events::class,
        ]);
    }
}
