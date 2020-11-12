<?php

namespace App\Form;

use App\Entity\Adherents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmer le mot de passe']
            ])
            ->add('adresse')
            ->add('telephone', TelType::class)
            ->add('isActPotager', CheckboxType::class, [
                'label' => 'Potager',
                'required' => false,
            ])
            ->add('isActVerger', CheckboxType::class, [
                'label' => 'Verger',
                'required' => false,
            ])
            ->add('isActRucher', CheckboxType::class, [
                'label' => 'Rucher',
                'required' => false,
            ])
            ->add('isActAnimation', CheckboxType::class, [
                'label' => 'Animation',
                'required' => false,
            ])
            ->add('isActPromotion', CheckboxType::class, [
                'label' => 'Promotion',
                'required' => false,
            ])
            ->add('isIntPotager', CheckboxType::class, [
                'label' => 'Potager',
                'required' => false,
            ])
            ->add('isIntVerger', CheckboxType::class, [
                'label' => 'Verger',
                'required' => false,
            ])
            ->add('isIntRucher', CheckboxType::class, [
                'label' => 'Rucher',
                'required' => false,
            ])
            ->add('isIntAnimation', CheckboxType::class, [
                'label' => 'Animation',
                'required' => false,
            ])            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adherents::class,
        ]);
    }
}