<?php

namespace App\Form;

use App\Entity\Centres;
use App\Entity\HistoriqueRendezVous;
use App\Entity\RendezVous;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class SelectionDateHeureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('immatriculation')
            // ->add('proprietaire')
            // ->add('contact')
            // ->add('mail')
            // ->add('adresse')
            // ->add('datePriseRendezVous')
            ->add('dateRendezVous', DateType::class, [
                'label' => 'Date de rendez-vous',
                // 'class' => 'datetimePicker',
                // 'html5' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimePicker',
                ],
                //'data' => new \DateTime('now'),
            ])
            ->add('heureRendezVous', TimeType::class, [
                'label' => 'Heure de rendez-vous',
                // 'class' => 'datetimePicker',
                // 'html5' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'datetimePicker',
                ],
                //'data' => new \DateTime('now'),
            ])
            // ->add('confirmation')
            // ->add('dateHeureArriveRendezVous')
            // ->add('dateHeureFinVisite')
            // ->add('dateHeureDebutVisite')
            // ->add('annulationRendezVous')
            // ->add('dateHeureAnnulationRendezVous')
            // ->add('codeRendezVous')
            // ->add('dateModificationRendezVous')
            // ->add('dateOrigineRendezVous')
            // ->add('nombreModification')
            /* ->add('historiqueRendezVous', EntityType::class, [
                'class' => HistoriqueRendezVous::class,
                'choice_label' => 'id',
            ]) */
            /* ->add('centre', EntityType::class, [
                'class' => Centres::class,
                'choice_label' => 'id',
            ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
