<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class DiffusionMailsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
          ->add('tous', CheckboxType::class, [
              'label'    => 'Tous les membres actifs',
              'required' => false,
          ])
          ->add('administrateurs', CheckboxType::class, [
              'label'    => 'Administrateurs',
              'required' => false,
          ])
          ->add('referent', CheckboxType::class, [
              'label'    => 'Référents',
              'required' => false,
          ])
          ->add('adherentTous', CheckboxType::class, [
              'label'    => 'Tous',
              'required' => false,
          ])
          ->add('adherentP', CheckboxType::class, [
              'label'    => 'Potager',
              'required' => false,
          ])
          ->add('adherentR', CheckboxType::class, [
              'label'    => 'Rucher',
              'required' => false,
          ])
          ->add('adherentV', CheckboxType::class, [
              'label'    => 'Verger',
              'required' => false,
          ])
          ->add('adherentE', CheckboxType::class, [
              'label'    => 'Evènements',
              'required' => false,
          ])
          ->add('adherentCom', CheckboxType::class, [
              'label'    => 'Communication',
              'required' => false,
          ])
          ->add('adherentIntP', CheckboxType::class, [
              'label'    => 'Potager',
              'required' => false,
          ])
          ->add('adherentIntR', CheckboxType::class, [
              'label'    => 'Rucher',
              'required' => false,
          ])
          ->add('adherentIntV', CheckboxType::class, [
              'label'    => 'Verger',
              'required' => false,
          ])
          ->add('adherentIntE', CheckboxType::class, [
              'label'    => 'Evènements',
              'required' => false,
          ])
          ->add('adherentArchive', CheckboxType::class, [
              'label'    => 'Adhérents Archivés',
              'required' => false,
          ])
          ->add('message', TextareaType::class, [
              'required' => true
            ])
          ->add('object', TextType::class, [
              'required' => true
            ])

            ->add('annee', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy',
            ])
          ;
    }

}
