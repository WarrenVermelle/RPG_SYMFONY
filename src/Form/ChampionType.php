<?php

namespace App\Form;

use App\Entity\Champion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChampionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('gender')
            ->add('img')
            ->add('level')
            ->add('gold')
            ->add('hp')
            ->add('mp')
            ->add('intel')
            ->add('strength')
            ->add('agi')
            ->add('actif')
            ->add('xp')
            ->add('player')
            ->add('race')
            ->add('faction')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Champion::class,
        ]);
    }
}
