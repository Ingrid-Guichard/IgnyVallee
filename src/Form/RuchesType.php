<?php

namespace App\Form;

use App\Entity\Ruchers;
use App\Entity\Ruches;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RuchesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomRuche', TextType::class, [
                'required' => true,
            ])
            ->add('modeleRuche', TextType::class, [
                'required' => true,
            ])
            ->add('plancherRuche', TextType::class, [
                'required' => true,
            ])
            ->add('emplacementRuche', TextType::class, [
                'required' => true,
            ])
            ->add('couvreCadreRuche', TextType::class, [
                'required' => true,
            ])
            ->add('toitRuche', TextType::class, [
                'required' => true,
            ])
            ->add('dateInstallationRuche', DateType::class, [
                'required' => true,
            ])
            ->add('origineColonie', TextType::class, [
                'required' => true,
            ])
            ->add('dateInstallationColonie', DateType::class, [
                'required' => true,
            ])
            ->add('especeColonie', TextType::class, [
                'required' => true,
            ])
            ->add('naissanceReine', DateType::class, [
                'required' => true,
            ])
            ->add('nourrisseurs', TextType::class, [
                'required' => true,
            ])
            ->add('muselieres', ChoiceType::class,
                array('choices' => array(
                    'Oui' => true,
                    'Non' => false),
                    'multiple' => false,
                    'expanded' => true)
            )
            ->add('rucher', EntityType::class, [
                'required' => false,
                'class' => Ruchers::class,
                'choice_label' => 'nomRucher'
            ])
        ;

        $builder->get('dateInstallationRuche')->addModelTransformer(new CallbackTransformer(
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

        $builder->get('dateInstallationColonie')->addModelTransformer(new CallbackTransformer(
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

        $builder->get('naissanceReine')->addModelTransformer(new CallbackTransformer(
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
            'data_class' => Ruches::class,
        ]);
    }
}
