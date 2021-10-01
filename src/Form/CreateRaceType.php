<?php

namespace App\Form;

use App\Entity\Race;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CreateRaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('race')
            ->add('ratio_hp')
            ->add('ratio_mp')
            ->add('ratio_intel')
            ->add('ratio_strength')
            ->add('ratio_agi')
            ->add('file_HumainH', FileType::class, [
                'label' => 'Image Humain H',
                'required' => false
            ])
            ->add('file_HumainF', FileType::class, [
                'label' => 'Image Humain F',
                'required' => false
            ])
            ->add('file_ElfH', FileType::class, [
                'label' => 'Image Elf H',
                'required' => false
            ])
            ->add('file_ElfF', FileType::class, [
                'label' => 'Image Elf F',
                'required' => false
            ])
            ->add('file_OrcH', FileType::class, [
                'label' => 'Image Orc H',
                'required' => false
            ])
            ->add('file_OrcF', FileType::class, [
                'label' => 'Image Orc F',
                'required' => false
            ])
            ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Race::class,
        ]);
    }
}
