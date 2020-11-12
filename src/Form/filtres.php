<?php


namespace App\Form;


use App\Entity\Activites;
use App\Entity\Adherents;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;


class filtres extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('admins', CheckboxType::class, [
                'label' => 'Administrateurs',
                'required' => false,
            ])
            ->add('referentsP', CheckboxType::class, [
                'label' => 'Référents Potager',
                'required' => false,
            ])
            ->add('referentsR', CheckboxType::class, [
                'label' => 'Référents Rucher',
                'required' => false,
            ])
            ->add('referentsV', CheckboxType::class, [
                'label' => 'Référents Verger',
                'required' => false,
            ])
            ->add('membresP', CheckboxType::class, [
                'label' => 'Membres Potager',
                'required' => false,
            ])
            ->add('membresR', CheckboxType::class, [
                'label' => 'Membres Rucher',
                'required' => false,
            ])
            ->add('membresV', CheckboxType::class, [
                'label' => 'Membres Verger',
                'required' => false,
            ])
            ->add('membresA', CheckboxType::class, [
                'label' => 'Membres Animation',
                'required' => false,
            ])
            ->add('membresPr', CheckboxType::class, [
                'label' => 'Membres Promotion',
                'required' => false,
            ])
            ->add('intsP', CheckboxType::class, [
                'label' => 'Intéressés Potager',
                'required' => false,
            ])
            ->add('intsR', CheckboxType::class, [
                'label' => 'Intéressés Rucher',
                'required' => false,
            ])
            ->add('intsV', CheckboxType::class, [
                'label' => 'Intéressés Verger',
                'required' => false,
            ])
            ->add('intsA', CheckboxType::class, [
                'label' => 'Intéressés Animation',
                'required' => false,
            ])
            ->add('archives', CheckboxType::class, [
                'label' => 'Adhérents archivés',
                'required' => false,
            ])
            ->add('nom', TextType::class, [
                'required' => false,
            ])
            ->add('prenom', TextType::class, [
                'required' => false,
            ])
            ->add('anneeCotis', DateType::class, [
                'required' => false,
                'widget' => 'single_text',
                'html5' => false,
                'format' => 'yyyy',
            ])
/*            ->add('anneeCotis', CheckboxType::class, [
                'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder()
                    ->select('YEAR(a.debutAdhesion)')
                    ->from('Adherents','a');
                    }
                    ])
            ->add('anneeCotis', CheckboxType::class, [
                'class' => Activites::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'nom',
            ])*/
        ;
    }
}