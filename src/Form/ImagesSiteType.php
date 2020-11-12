<?php

namespace App\Form;

use App\Entity\Partenaires;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class ImagesSiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageName', FileType::class, [
              'label' => 'Image (PNG, JPEG, JPG ou SVG)',
              'mapped' => false,
              'required' => false,
              'constraints' => [
                new File([
                  'mimeTypes' => [
                    'image/png',
                    'image/jpeg',
                    'image/jpg',
                    'image/svg+xml',
                    'image/gif'
                  ],
                'mimeTypesMessage' => 'Veuillez entrer une image valide'
                ])
              ],
            ])
        ;
    }
}
