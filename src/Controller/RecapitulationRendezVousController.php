<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use App\Repository\NombreJourMaximumRendezVousRepository;
use App\Repository\NombreRendezVousParHeureRepository;
use App\Repository\NombreModificationMaximumRepository;
use App\Repository\NombreVehiculeMaximumRendezVousRepository;
use App\Repository\DureeLimiteAvantRendezVousRepository;
use App\Form\SelectionDateHeureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

final class RecapitulationRendezVousController extends AbstractController
{
    #[Route('/recapitulation/rendez/vous', name: 'app_recapitulation_rendez_vous')]
    public function index(): Response
    {
        return $this->render('recapitulation_rendez_vous/index.html.twig', [
            'controller_name' => 'RecapitulationRendezVousController',
        ]);
    }

    #[Route('/liste/rendez/vous', name: 'app_liste_rendez_vous', methods: ['GET', 'POST'])]
    public function listeRendezVous(
        Request $request,
        DureeLimiteAvantRendezVousRepository $dureeLimiteAvantRendezVousRepository,
        NombreJourMaximumRendezVousRepository $nombreJourMaximumRendezVousRepository,
        NombreRendezVousParHeureRepository $nombreRendezVousParHeureRepository,
        NombreModificationMaximumRepository $nombreModificationMaximumRepository,
        NombreVehiculeMaximumRendezVousRepository $nombreVehiculeMaximumRendezVousRepository,
        EntityManagerInterface $entityManager,
        RendezVousRepository $rendezVousRepository,
        PaginatorInterface $paginator): Response
    {
        $rendezVou = new RendezVous();
        $form = $this->createForm(SelectionDateHeureType::class, $rendezVou);
        $form->handleRequest($request);
        $dateString = '';

        $nombreVehiculeMaximum = $nombreVehiculeMaximumRendezVousRepository->findOneBy([], ['dateApplication' => 'DESC']);
        $nombreModificationMaximum = $nombreModificationMaximumRepository->findOneBy([], ['dateApplication' => 'DESC']);
        $nombreRendezVousParHeure = $nombreRendezVousParHeureRepository->findOneBy([], ['dataApplication' => 'DESC']);
        $nombreJourMaximumRendezVous = $nombreJourMaximumRendezVousRepository->findOneBy([], ['dateApplication' => 'DESC']);
        $dureeLimiteAvantRendezVous = $dureeLimiteAvantRendezVousRepository->findOneBy([], ['dateApplication' => 'DESC']);
        $heureOuverture = '07:00';
        $heureFermeture = '15:00';

        $intervalRendezVous = (int)(60/$nombreRendezVousParHeure->getNombreRendezVous());

        $availableSlots = [];

        if ($request->isMethod('POST')){
            $dateString = $request->request->get('dateRendezVous');
        } else {
            $dateString = $request->query->get('dateRendezVous');
            //$dateFormater = \DateTime::createFromFormat('d/m/Y', $dateString);
        }

        if ($dateString != '' && $dateString != null) {
            //$dateString = '25/11/2025'; // format d/m/Y
            $parts = explode('/', $dateString); // ['25', '11', '2025']
            // Réarranger dans l'ordre Y-m-d
            $dateFormatter = implode('-', array_reverse($parts)); // '2025-11-25'
            $date = new \DateTime($dateFormatter);
            /* $class = \DateTime::class;
            $date = new $class::createFromFormat('d/m/Y', $dateString); */
        } else {
            $date = new \DateTime(date('Y-m-d'));
        }

        $start = new \DateTime($date->format('Y-m-d') . ' ' . $heureOuverture);
        $end = new \DateTime($date->format('Y-m-d') . ' ' . $heureFermeture);
        $interval = new \DateInterval('PT' . $intervalRendezVous . 'M');
        $slots = [];
        for ($time = clone $start; $time < $end; $time->add($interval)) {
            $slots[] = clone $time;
        }

        $taken = $rendezVousRepository->findBy(['dateRendezVous' => $date]);
        $takenTimes = array_map(
            fn($rdv) => $rdv->getHeureRendezVous()->format('H:i'),
            $taken
        );
        /* foreach ($slots as $slot){
            $heure = $slot->format('H:i');

            // Compter le nombre de réservations existantes pour cette heure
            $count = 0;
            foreach ($taken as $rdv) {
                if ($rdv->getHeureRendezVous()->format('H:i') === $heure && $rdv->getDateRendezVous()->format('Y-m-d')){
                    $count++;
                }
            }

            // Si le nombre est inférieur au max, ajouter le créneau
            if ($count >= $nombreVehiculeMaximum->getNombreVehicule()) {
                //$heureActuelle = (int)(new \DateTime())->format('H:i');
                //$limite = (int)$dureeLimiteAvantRendezVous->getNombreHeure();

                $now = new \DateTime();                           // maintenant
                $limite = $dureeLimiteAvantRendezVous->getNombreHeure();  // ex: 2 h

                // date complète du RDV (date + heure)
                $rdvDateTime = clone $date;                       // $date contient déjà la date du RDV
                $rdvDateTime->setTime(substr($heure, 0, 2), substr($heure, 3, 2));

                // heure limite = maintenant + limite (ex : maintenant + 2h)
                $limiteHeure   = (int)$limite->format('H');
                $limiteMinute  = (int)$limite->format('i');
                $heureLimite = clone $now;
                //$heureLimite->modify("+$limite hour");
                $heureLimite->modify("+{$limiteHeure} hour + {$limiteMinute} minutes");
                //if($date->format('Y-m-d') === new \DateTime(date('Y-m-d')) && ($heure < $dureeLimiteAvantRendezVous->getNombreHeure())) {
                if(($date->format('Y-m-d') === (new \DateTime())->format('Y-m-d')) && ($rdvDateTime < $heureLimite)) {
                    continue;
                }
                 $availableSlots[] = $slot;
            }
        } */
        $availableSlots = $taken;

        return $this->render('recapitulation_rendez_vous/index.html.twig', [
            // 'form' => $form->createView(),
            'form' => $form,
            'rendez_vou' => $rendezVou,
            'availableSlots' => $availableSlots,
            'date' => $date,
            'jourAffichable' => $nombreJourMaximumRendezVous->getNombreJour(),
        ]);
    }
}
