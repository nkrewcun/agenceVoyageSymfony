<?php

namespace App\Form;

use App\Entity\Destination;
use App\Entity\Sejour;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DestinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $class = 'form-control';
        $builder
            ->add('lieu', TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'class' => $class,
                        'placeholder' => 'Saisissez un lieu ici'
                    ]
                ])
            ->add('type', TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'class' => $class,
                        'placeholder' => 'Saisissez un type ici'
                    ]
                ])
            ->add('pays', TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'class' => $class,
                        'placeholder' => 'Saisissez un pays ici'
                    ]
                ])
            ->add('dateOuverture', DateType::class,
                [
                    'required' => false,
                    'widget' => 'single_text',
                    'invalid_message' => 'Le format de la date est invalide',
                    'attr' => [
                        'class' => $class,
                    ]
                ])
            ->add('nbStar', IntegerType::class,
                [
                    'required' => true,
                    'attr' => [
                        'class' => $class,
                        'placeholder' => 'Saisissez un nombre ici',
                        'min' => 0,
                        'max' => 5
                    ]
                ])
            ->add('sejour', EntityType::class,
                [
                    'required' => true,
                    'class' => Sejour::class,
                    'attr' => [
                        'class' => $class,
                        'placeholder' => 'Saisissez un nombre ici'
                    ]
                ])
            ->add('submit', SubmitType::class,
                [
                    'label' => 'Envoyer',
                    'attr' => [
                        'class' => 'btn btn-secondary',
                    ]
                ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Destination::class,
        ]);
    }
}
