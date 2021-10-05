<?php

namespace App\Form;

use App\Entity\Champion;
use App\Entity\Faction;
use App\Entity\Gender;
use App\Entity\Race;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
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
            ->add('gender', EntityType::class, [
                'placeholder' => 'Choisissez votre Genre',
                'class' => Gender::class
            ])
            ->add('race', EntityType::class, [
                'placeholder' => 'Choisissez votre Race',
                'class' => Race::class
            ])
            ->add('faction', EntityType::class, [
                'class' => Faction::class,
                'placeholder' => 'Choisissez votre Faction',
                'query_builder' => function(EntityRepository $repo){
                    return $repo->createQueryBuilder('f')
                        ->orderBy('f.faction', 'ASC');
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Champion::class,
        ]);
    }
}
