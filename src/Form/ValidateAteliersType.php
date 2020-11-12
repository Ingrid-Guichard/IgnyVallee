<?php

namespace App\Form;

use App\Entity\Referents;
use App\Entity\Ateliers;
use App\Entity\Partenaires;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ValidateAteliersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('heuresGestionAtelier')
            ->add('referents', EntityType::class, [
                'required' => true,
                'class' =>Referents::class,
                'choice_label' => 'adherent.prenom',
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ateliers::class,
        ]);
    }
}
