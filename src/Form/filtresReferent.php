<?php


namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class filtresReferent extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('activite', ChoiceType::class,
                array('choices' => array(
                    'Choisir une activité' => '',
                    'Membres Potager' => 'membresP',
                    'Membres Rucher' => 'membresR',
                    'Membres Verger' => 'membresV'
                )))
            ->add('nom', TextType::class, [
                'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'required' => false,
            ])
        ;
    }
}