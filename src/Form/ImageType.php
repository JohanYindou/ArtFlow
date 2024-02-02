<?php

namespace App\Form;

use App\Entity\Image;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'attr' => [
                    'class' => 'form-control mb-3',
                ]
            ])

            ->add('path', FileType::class, [
                'required' => true,
                'mapped' => false,
                'label' => 'Image',
                'attr' => [
                    'accept' => 'image/*',
                    'class' => 'form-control mb-3',
                ],
            ])

            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'required' => true,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'flex items-center gap-2 mb-3',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Image::class,
        ]);
    }
}
