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
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

final class SelectionRendezVousController extends AbstractController
{
    #[Route('/selection/rendez/vous', name: 'app_selection_rendez_vous', methods: ['GET', 'POST'])]
    public function index(Request $request, DureeLimiteAvantRendezVousRepository $dureeLimiteAvantRendezVousRepository, NombreJourMaximumRendezVousRepository $nombreJourMaximumRendezVousRepository, NombreRendezVousParHeureRepository $nombreRendezVousParHeureRepository, NombreModificationMaximumRepository $nombreModificationMaximumRepository, NombreVehiculeMaximumRendezVousRepository $nombreVehiculeMaximumRendezVousRepository, EntityManagerInterface $entityManager, RendezVousRepository $rendezVousRepository, PaginatorInterface $paginator): Response
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
        }

        if ($dateString != '' && $dateString != null) {
            $date = new \DateTime($dateString);
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
        foreach ($slots as $slot){
            $heure = $slot->format('H:i');

            // Compter le nombre de réservations existantes pour cette heure
            $count = 0;
            foreach ($taken as $rdv) {
                if ($rdv->getHeureRendezVous()->format('H:i') === $heure && $rdv->getDateRendezVous()->format('Y-m-d')){
                    $count++;
                }
            }

            // Si le nombre est inférieur au max, ajouter le créneau
            if ($count < $nombreVehiculeMaximum->getNombreVehicule()) {
                $availableSlots[] = $slot;
            }
            /* if (!in_array($slot->format('H:i'), $takenTimes)){
                $availableSlots[] = $slot;
            } */
        }

        /* return this->render('selection_rendez_vous/index.html.twig', [
            'availableSlots' => availableSlots,
        ]); */

        /* if ($form->isSubmitted() && $form->isValid()) {
            //return $this->redirectToRoute('app_rendez_vous_index', [], Response::HTTP_SEE_OTHER);

            $date = $form->get('dateRendezVous')->getData() ?? new \DateTime();

            // Génération des créneaux (exemple : 08h00 → 17h00)
            $start = new \DateTime($date->format('Y-m-d') . ' 08:00');
            $end   = new \DateTime($date->format('Y-m-d') . ' 17:00');

            $interval = new \DateInterval('PT20M'); // 20 minutes
            //dump($interval);
            $slots = [];
            //for ($time = clone $start; $time <= $end; $time->add($interval)) {
            for ($time = clone $start; $time < $end; $time->add($interval)) {
                $slots[] = clone $time;
            }

            // Récupérer les heures déjà réservées
            $taken = $rendezVousRepository->findBy(['dateRendezVous' => $date]);

            $takenTimes = array_map(
                fn($rdv) => $rdv->getHeureRendezVous()->format("H:i"),
                $taken
            );

            // Filtrer
            foreach ($slots as $slot) {
                if (!in_array($slot->format('H:i'), $takenTimes)) {
                    $availableSlots[] = $slot;
                }
            }

        } */

        return $this->render('selection_rendez_vous/index.html.twig', [
            // 'form' => $form->createView(),
            'form' => $form,
            'rendez_vou' => $rendezVou,
            'availableSlots' => $availableSlots,
            'date' => $date,
        ]);
    }

    #[Route('/rendez-vous/reserver/{date}/{time}', name: 'app_rdv_reserver')]
    public function reserver($date, $time, EntityManagerInterface $em)
    {
        $rdv = new RendezVous();
        $rdv->setDateRendezVous(new \DateTime($date));
        $rdv->setHeureRendezVous(new \DateTime($time));

        $em->persist($rdv);
        $em->flush();

        return $this->redirectToRoute('app_rdv_confirm');
    }
}
