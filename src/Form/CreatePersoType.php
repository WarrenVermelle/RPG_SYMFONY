<?php

namespace App\Form;

use App\Entity\Champion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class CreatePersoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank([
                        "message" => "Ce champs ne peut pas être vide"
                    ]),
                    new Regex([
                        "pattern" => "/(?i)^(?:(?![×Þß÷þø])[-'0-9a-zÀ-ÿ])+$/mu",
                        "match" => true,
                        "message" => "Pas d'espace dans le pseudo ou de caractères spéciaux"
                    ])
                ]
            ])
            ->add('gender', ChoiceType::class, [
                "choices" => [
                    "Femme" => 0,
                    "Homme" => 1
                ]
            ])
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
