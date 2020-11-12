<?php


namespace App\Form;


use App\Entity\Adherents;
use App\Entity\Referents;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EditAdherentsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email', EmailType::class)
            ->add('adresse')
            ->add('telephone', TelType::class)
            ->add('debutAdhesion')
            ->add('finAdhesion')
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
            ])
            ->add('isPayed', ChoiceType::class,
                array('choices' => array(
                    'Oui' => true,
                    'Non' => false),
                    'multiple' => false,
                    'expanded' => true))
            ->add('typePaiement', ChoiceType::class,
                array('choices' => array(
                    '' => 'Pas payé',
                    'Cheque' => 'Cheque',
                    'Espece' => 'Espece',
                    'Virement' => 'Virement'
                )))
            ->add('typeAdhesion', ChoiceType::class,
                array('choices' => array(
                    'Etudiants et personnes non imposables' => 'Etudiants et personnes non imposables',
                    'Particuliers' => 'Particuliers',
                    'Bienfaiteurs, associations, et personnes morales' => 'Bienfaiteurs, associations, et personnes morales',
                )))
            ->add('isAdmin', ChoiceType::class,
                array('choices' => array(
                    'Oui' => true,
                    'Non' => false),
                    'expanded' => true))
            ->add('isReferentP', CheckboxType::class, [
                'label' => 'Potager',
                'required' => false,
            ])
            ->add('isReferentR', CheckboxType::class, [
                'label' => 'Rucher',
                'required' => false,
            ])
            ->add('isReferentV', CheckboxType::class, [
                'label' => 'Verger',
                'required' => false,
            ])
            ->add('isArchive', ChoiceType::class,
                array('choices' => array(
                    'Oui' => true,
                    'Non' => false),
                    'expanded' => true))//Retirés : mdp, admin, participant, ateliers, referent, activites, arbres
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Adherents::class,
        ]);
    }
}
