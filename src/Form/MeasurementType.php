<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Measurement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MeasurementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class)
            ->add('temperature', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Enter temperature in °C',
                    'step' => 1,
                ],
            ])
            ->add('precipitation', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Enter precipitation percentage',
                    'step' => 1,
                    'min' => 0,
                    'max' => 100,
                ],
            ])
            ->add('humidity', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Enter humidity percentage',
                    'step' => 1,
                    'min' => 0,
                    'max' => 100,
                ],
            ])
            ->add('wind', IntegerType::class, [
                'attr' => [
                    'placeholder' => 'Enter wind speed in km/h',
                    'step' => 1,
                    'min' => 0,
                ],
            ])
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'city',
                'placeholder' => 'Select a location',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Measurement::class,
        ]);
    }
}
