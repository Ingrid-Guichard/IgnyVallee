<?php

namespace App\Form;

use App\Entity\Activites;
use App\Entity\Ateliers;
use App\Entity\Referents;
use App\Entity\Taches;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAteliersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateDebut', DateTimeType::class)
            ->add('dateFin', DateTimeType::class)
            ->add('description')
            ->add('heuresGestionAtelier')

            /* Retirer le commentaire pour ajouter les adhérents dans l'édition'
                 ->add('adherents')
            */

            ->add('taches', EntityType::class, [
                'required' => false,
                'class' => Taches::class,
                'choice_label' => 'nom',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('referents', EntityType::class, [
                'required' => false,
                'class' => Referents::class,
                'choice_label' => 'adherent.prenom',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('activite', EntityType::class, [
                'required' => false,
                'class' => Activites::class,
                'choice_label' => 'nom',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ateliers::class,
        ]);
    }
}
