<?php

namespace App\Form;

use App\Entity\NombreRendezVousParHeure;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NombreRendezVousParHeureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombreRendezVous')
            ->add('dataApplication')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => NombreRendezVousParHeure::class,
        ]);
    }
}
