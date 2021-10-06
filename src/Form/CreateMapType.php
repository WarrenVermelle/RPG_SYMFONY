<?php

namespace App\Form;

use App\Entity\Map;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateMapType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('map_name')
            ->add('img')
            ->add('shop')
            ->add('fight')
            ->add('marchand')
            ->add('map_top')
            ->add('map_right')
            ->add('map_bottom')
            ->add('map_left')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Map::class,
        ]);
    }
}
