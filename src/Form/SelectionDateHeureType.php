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
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SelectionDateHeureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('immatriculation', TextType::class,[
                'label' => "Veuillez saisir l'immatricutaion de votre véhiciule",
                'required' => true,
            ])
            ->add('proprietaire', TextType::class,[
                'label' => "Veuillez saisir votre nom et prénom",
                'required' => true,
            ])
            ->add('contact', TextType::class,[
                'label' => "Veuillez saisir numéro de téléphone",
                'required' => true,
            ])
            ->add('mail', TextType::class,[
                'label' => "Veuillez saisir votre e-mail",
                'required' => false,
            ])
            ->add('adresse', TextType::class,[
                'label' => "Veuillez saisir votre adresse",
                'required' => true,
            ])
            // ->add('datePriseRendezVous')
            ->add('centre', EntityType::class, [
                'label' => "Veuillez selectionner le centre de votre rendez-vous",
                'class' => Centres::class,
                'choice_label' => 'centre',
                'required' => true,
            ])
            ->add('dateRendezVous', DateType::class, [
                'label' => 'Date de rendez-vous',
                // 'class' => 'datetimePicker',
                // 'html5' => false,
                'widget' => 'single_text',
                'required' => true,
                'disabled' => true,
                'attr' => [
                    // 'class' => 'form-control datetimePicker datepicker js-datepicker',
                    // 'class' => 'form-control js-datepicker',
                    'class' => 'form-control',
                    // 'data-provide' => 'datepicker',
                    'data-date-format' => 'dd/mm//yyyy',
                    'placeholder' => 'jj/mm/aaaa',
                    'autocomplete' => 'off',
                ],
                // 'data' => new \DateTime('now'),
            ])
            ->add('heureRendezVous', TimeType::class, [
                'label' => 'Heure de rendez-vous',
                // 'class' => 'datetimePicker',
                // 'html5' => false,
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    // 'data-provide' => 'datepicker',
                    'autocomplete' => 'off'
                ],
                //'data' => new \DateTime('now'),
                'required' => true,
                'disabled' => true,
            ])
            ->add('confirmation', CheckboxType::class,[
                'label' => "Veuillez confirmer votre rendez-vous",
                'required' => true,
            ])
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
