<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('city', null, [
                'trim' => true,
                'attr' => [
                    'placeholder' => 'Enter city name',
                ],
            ])
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'Poland' => 'PL',
                    'Germany' => 'DE',
                    'France' => 'FR',
                    'Spain' => 'ES',
                    'Italy' => 'IT',
                    'United Kingdom' => 'GB',
                    'United States' => 'US',
                ],
                'placeholder' => 'Select a country',
            ])
            ->add('latitude', NumberType::class, [
                'scale' => 7,
                'attr' => [
                    'placeholder' => 'e.g., 53.428542',
                    'step' => 'any',
                    'min' => -90,
                    'max' => 90,
                ],
            ])
            ->add('longitude', NumberType::class, [
                'scale' => 7,
                'attr' => [
                    'placeholder' => 'e.g., 14.552812',
                    'step' => 'any',
                    'min' => -180,
                    'max' => 180,
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Location::class,
        ]);
    }
}
