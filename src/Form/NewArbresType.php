<?php

namespace App\Form;

use App\Entity\Activites;
use App\Entity\Adherents;
use App\Entity\Arbres;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewArbresType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etatArbre', TextareaType::class, [
                'required' => false
            ])
            ->add('nomFruitArbre', TextType::class, [
                'required' => true
            ])
            ->add('ageArbre', IntegerType::class, [
                'required' => false
            ])
            ->add('numeroArbre', IntegerType::class, [
                'required' => true
            ])
            ->add('adherent', EntityType::class, [
                'required' => false,
                'class' => Adherents::class,
                'choice_label' => 'nom',
                ])
            ->add('activite', EntityType::class, [
                'required' => false,
                'class' => Activites::class,
                'choice_label' => 'nom',
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Arbres::class,
        ]);
    }
}
