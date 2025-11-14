<?php

namespace App\Form;

use App\Entity\RendezVous;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('immatriculation')
            ->add('proprietaire')
            ->add('contact')
            ->add('mail')
            ->add('adresse')
            ->add('datePriseRendezVous')
            ->add('dateRendezVous')
            ->add('heureRendezVous')
            ->add('confirmation')
            ->add('dateHeureArriveRendezVous')
            ->add('dateHeureFinVisite')
            ->add('dateHeureDebutVisite')
            ->add('annulationRendezVous')
            ->add('dateHeureAnnulationRendezVous')
            ->add('codeRendezVous')
            ->add('dateModificationRendezVous')
            ->add('dateOrigineRendezVous')
            ->add('nombreModification')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
