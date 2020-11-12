<?php


namespace App\Form;


use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;

class FiltresAteliersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('date', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy',
            ])

            ->add('verger', CheckboxType::class , [
                'required' => false])
            ->add('potager', CheckboxType::class, [
                'required' => false])
            ->add('rucher', CheckboxType::class, [
                'required' => false])
        ;
    }
}