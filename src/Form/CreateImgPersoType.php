<?php

namespace App\Form;

use App\Entity\ImgPerso;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateImgPersoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('file_img', FileType::class, [
                'label' => 'Image'
            ])
            ->add('gender')
            ->add('race')
            ->add('faction')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ImgPerso::class,
        ]);
    }
}
