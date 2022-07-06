<?php

namespace App\Form;

use App\Entity\Figures;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FigureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description'
            ])
            //TODO Dyn groups where id exemple in https://github.com/Eyefiz/eyefiz-digital/blob/main/src/Form/CarriereType.php
            ->add('groups', ChoiceType::class, [
                'label' => 'Groupe',
                'choice' => [
                    'Mc Twist' => 'Mc Twist',
                    'Jib' => "Jib",
                    'Grabs' => "Grabs",
                    'Lipslide' => "Lipslide",
                    'Air to Fakie' => "Air to Fakie"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Figures::class,
        ]);
    }
}
