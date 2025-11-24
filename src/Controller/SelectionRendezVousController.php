<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use App\Form\SelectionDateHeureType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

final class SelectionRendezVousController extends AbstractController
{
    #[Route('/selection/rendez/vous', name: 'app_selection_rendez_vous')]
    public function index(Request $request, EntityManagerInterface $entityManager, RendezVousRepository $rendezVousRepository, PaginatorInterface $paginator): Response
    {
        $rendezVou = new RendezVous();
        $form = $this->createForm(SelectionDateHeureType::class, $rendezVou);
        $form->handleRequest($request);
        // dump($request);
        $availableSlots = [];

        if ($form->isSubmitted() && $form->isValid()) {
            echo("teste arriver ici");

            /* $date = $form->get('dateRendezVous')->getData() ?? new \DateTime();

            // Génération des créneaux (exemple : 08h00 → 17h00)
            $start = new \DateTime($date->format('Y-m-d') . ' 08:00');
            $end   = new \DateTime($date->format('Y-m-d') . ' 17:00');

            $interval = new \DateInterval('PT20M'); // 20 minutes
            // dump($interval);
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
            } */
        }

        return $this->render('selection_rendez_vous/index.html.twig', [
            //'form' => $form->createView(),
            'form' => $form,
            'rendez_vou' => $rendezVou,
            'availableSlots' => $availableSlots
        ]);
        /* return $this->render('selection_rendez_vous/index.html.twig', [
            'controller_name' => 'SelectionRendezVousController',
        ]); */
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
