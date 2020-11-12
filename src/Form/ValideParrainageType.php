<?php

namespace App\Form;

use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;


class ValideParrainageType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder;
    }
}
