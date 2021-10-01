<?php

namespace App\Form;

use App\Entity\Faction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateFactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('faction')
            ->add('coef_hp')
            ->add('coef_mp')
            ->add('coef_intel')
            ->add('coef_strength')
            ->add('coef_agi')
            ->add('file_HumainH', FileType::class, [
                'label' => 'Image Humain H'
            ])
            ->add('file_HumainF', FileType::class, [
                'label' => 'Image Humain F'
            ])
            ->add('file_ElfH', FileType::class, [
                'label' => 'Image Elf H'
            ])
            ->add('file_ElfF', FileType::class, [
                'label' => 'Image Elf F'
            ])
            ->add('file_OrcH', FileType::class, [
                'label' => 'Image Orc H'
            ])
            ->add('file_OrcF', FileType::class, [
                'label' => 'Image Orc F'
            ])
            ->add('updatedAt')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Faction::class,
        ]);
    }
}
