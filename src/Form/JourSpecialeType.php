<?php

namespace App\Form;

use App\Entity\JourSpeciale;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JourSpecialeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateSpeciale')
            ->add('ouvrable')
            ->add('heureDebut')
            ->add('heureFin')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => JourSpeciale::class,
        ]);
    }
}
