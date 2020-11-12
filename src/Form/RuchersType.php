<?php

namespace App\Form;

use App\Entity\Ruchers;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RuchersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomRucher', TextType::class, [
                'required' => true,
            ])
            ->add('descriptionRucher', TextareaType::class, [
                'required' => true,
            ])
            ->add('lieuRucher', TextType::class, [
                'required' => true,
            ])
            ->add('partenaireRucher', TextType::class, [
                'required' => false,
            ])
            ->add('dateCreationRucher', DateType::class, [
                'required' => true,
            ])
        ;

        $builder->get('dateCreationRucher')->addModelTransformer(new CallbackTransformer(
            function ($value) {
                if(!$value) {
                    return new \DateTime('now');
                }
                return $value;
            },
            function ($value) {
                return $value;
            }
        ));

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ruchers::class,
        ]);
    }
}
