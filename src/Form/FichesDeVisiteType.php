<?php

namespace App\Form;

use App\Entity\FichesDeVisite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichesDeVisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateVisite')
            ->add('objectifs', TextareaType::class, [
                'required' => false
            ])
            ->add('observations', TextareaType::class, [
                'required' => false
            ])
            ->add('poidsRuche', null, [
                'required' => false
            ])
            ->add('tauxAgressiviteAbeilles', RangeType::class, [
                    'attr' => [
                        'min' => 1,
                        'max' => 5,
                    ],
                ])
            ->add('cadre1', TextareaType::class, [
                'required' => false
            ])
            ->add('cadre2', TextareaType::class, [
                'required' => false
            ])
            ->add('cadre3', TextareaType::class, [
                'required' => false
            ])
            ->add('cadre4', TextareaType::class, [
                'required' => false
            ])
            ->add('cadre5', TextareaType::class, [
                'required' => false
            ])
            ->add('cadre6', TextareaType::class, [
                'required' => false
            ])
            ->add('cadre7', TextareaType::class, [
                'required' => false
            ])
            ->add('cadre8', TextareaType::class, [
                'required' => false
            ])
            ->add('cadre9', TextareaType::class, [
                'required' => false
            ])
            ->add('cadre10', TextareaType::class, [
                'required' => false
            ])
            ->add('calculVarroa', null, [
                'required' => false
            ])
            ->add('typeVisite', ChoiceType::class, [
                'choices'  => [
                    '' => '',
                    'Printemps' => 'Printemps',
                    'Récolte' => 'Récolte',
                    'Traitement Varroa' => 'Traitement Varroa',
                    'Hivernage' => 'Hivernage',
                    'Autre' => 'Autre',
                ],
            ])
            ->add('quantiteAbeilles', null, [
                'required' => false
            ])
            ->add('detectionReine', ChoiceType::class, [
                'choices'  => [
                    '' => '',
                    'Vue' => 'Vue',
                    'Marquée' => [
                        'bleue' => 'bleue',
                        'blanche' => 'blanche',
                        'jaune' => 'jaune',
                        'rouge' => 'rouge',
                        'verte' => 'verte',
                    ],
                ],
                'required' => false
            ])
            ->add('nourrissement', null, [
                'required' => false
            ])
            ->add('typeSirop', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'Sirop léger (50/50)' => 'Sirop léger (50/50)',
                    'Sirop lourd (1/3 eau, 2/3 sucre)' => 'Sirop lourd (1/3 eau, 2/3 sucre) ',
                ],
                'required' => false
            ])
            ->add('tempsVisite', null, [
                'required' => false
            ])
            ->add('cellulesRoyales', ChoiceType::class, [
                'choices' => [
                    '' => '',
                    'Oui, en bord de cadre' => 'Oui, en bord de cadre',
                    'Oui, au centre du cadre' => 'Oui, au centre du cadre',
                    'Non' => 'Non',
                    ],
                    'required' => false
                ])
            ->add('typeCouvain', ChoiceType::class,
                array('choices' => array(
                    'Frais' => 'Frais',
                    'Ouverts' => 'Ouverts',
                    'Operculés' => 'Operculés',
                    'Réguliers' => 'Réguliers',
                    'Clairsemés' => 'Clairsemés',
                    'Mâles' => 'Mâles'),
                    'multiple' => true,
                    'expanded' => true,
                    'required'=> false,))
            ->add('typeStructure1', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('typeStructure2', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('typeStructure3', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('typeStructure4', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('typeStructure5', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('typeStructure6', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('typeStructure7', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('typeStructure8', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('typeStructure9', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('typeStructure10', ChoiceType::class,
                array('choices' => array(
                    '' => '',
                    'Vide' => 'Vide',
                    'Partition' => 'Partition',
                    'Cire gauffrée' => 'Cire gauffrée',
                    'Jambage' => 'Jambage',
                    'Construit' => 'Construit'),
                    'required' => false,))
            ->add('reserveMiel', TextareaType::class, [
                'required' => false
            ])
            ->add('reservePollen', TextareaType::class, [
                'required' => false
            ])
            ->add('nbCadresCouvain', null, [
                'required' => false
            ])
            ->add('nbCadresMiel', null, [
                'required' => false
            ])
            ->add('nbCadresPollen', null, [
                'required' => false
            ])
        ;

        $builder->get('dateVisite')->addModelTransformer(new CallbackTransformer(
            function ($value) {
                if(!$value) {
                    return new \DateTime('now');
                }
                return $value;
            },
            function ($value) {
                return $value;
            }
        ))
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => FichesDeVisite::class,
        ]);
    }
}
