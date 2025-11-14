<?php

namespace App\Form;

use App\Entity\NombreVehiculeMaximumRendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NombreVehiculeMaximumRendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreVehicule')
            ->add('dateApplication')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NombreVehiculeMaximumRendezVous::class,
        ]);
    }
}
