<?php

namespace App\Form;

use App\Entity\Activite;
use App\Entity\Category;
use App\Entity\Destination;
use App\Entity\Sejour;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SejourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $class = 'form-control';
        $builder
            ->add('titre', TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'class' => $class,
                        'placeholder' => 'Saisissez un titre ici'
                    ]
                ])
            ->add('typeLogement', TextType::class,
                [
                    'required' => true,
                    'attr' => [
                        'class' => $class,
                        'placeholder' => 'Saisissez un type de logement ici'
                    ]
                ])
            ->add('nbPersonne', IntegerType::class,
                [
                    'required' => true,
                    'attr' => [
                        'class' => $class,
                        'placeholder' => 'Saisissez un nombre ici',
                        'min' => 0,
                        'max' => 20
                    ]
                ])
            ->add('description', TextareaType::class,
                [
                    'required' => true,
                    'attr' => [
                        'class' => $class,
                        'placeholder' => 'Saisissez une description ici',
                    ]
                ])
            ->add('category', EntityType::class,
                [
                    'label' => "Catégorie",
                    'required' => true,
                    'class' => Category::class,
                    'attr' => [
                        'class' => $class,
                    ]
                ])
            ->add('activites', EntityType::class,
                [
                    'required' => true,
                    'class' => Activite::class,
                    'multiple' => true,
                    'attr' => [
                        'class' => $class,
                    ]
                ])
            ->add('submit', SubmitType::class,
                [
                    'label' => 'Envoyer',
                    'attr' => [
                        'class' => 'btn btn-secondary',
                    ]
                ]);

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sejour::class,
        ]);
    }
}
