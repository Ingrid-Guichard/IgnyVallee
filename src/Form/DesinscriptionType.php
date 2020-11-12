<?php

namespace App\Form;

use App\Entity\Activites;
use App\Entity\Ateliers;
use App\Entity\Referents;
use App\Entity\Taches;
use Symfony\Component\Form\Button;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\CallbackTransformer;


class DesinscriptionType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder;
    }
}