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
use DateTimeImmutable;
use App\Service\PdfService;

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
        }

        return $this->render('selection_rendez_vous/index.html.twig', [
            // 'form' => $form->createView(),
            'form' => $form,
            'rendez_vou' => $rendezVou,
            'availableSlots' => $availableSlots,
            'date' => $date,
            'jourAffichable' => $nombreJourMaximumRendezVous->getNombreJour(),
        ]);
    }
    // ito fonction ambony tsy dia miasa fa navela eto fotsiny aloha
    #[Route('/rendez-vous/reserver/{date}/{time}', name: 'app_rdv_reserver', methods: ['GET', 'POST'])]
    public function reserver(
        $date,
        $time,
        Request $request,
        NombreVehiculeMaximumRendezVousRepository $nombreVehiculeMaximumRendezVousRepository,
        NombreJourMaximumRendezVousRepository $nombreJourMaximumRendezVousRepository,
        RendezVousRepository $rendezVousRepository,
        EntityManagerInterface $entityManager)
    {
        $rendezVou = new RendezVous();
        $rendezVou->setDateRendezVous(new \DateTime($date));
        $rendezVou->setHeureRendezVous(new \DateTime($time));
        $form = $this->createForm(SelectionDateHeureType::class, $rendezVou, [
            'label' => false,
        ]);
        $form->handleRequest($request);

        /* if ($form->isSubmitted() && $form->isValid()) { */
        if ($form->isSubmitted() && $form->isValid()) {
            // $rendezVou = $request->query->all(); // ou $form->getData()
            // $rendezVou = $form->getData();

            $code = uniqid();
            // resultat = $this->nettoyerTexte($texte);
            // strtoupper($texte);
            $rendezVou->setDatePriseRendezVous(new \DateTime());
            $rendezVou->setCodeRendezVous($code);
            $rendezVou->setAnnulationRendezVous(false);
            $rendezVou->setImmatriculation(
                strtoupper($this->nettoyerTexte($rendezVou->getImmatriculation()))
            );
            $rdvExiste = $rendezVousRepository->findOneBy([
                'immatriculation' => $rendezVou->getImmatriculation()
            ]);

            // $date = new ('2025-12-10'); // Exemple de date à tester
            $aujourdhui = new \DateTime(); // Aujourd'hui
            $nombreJourMaximumRendezVous = $nombreJourMaximumRendezVousRepository
                ->findOneBy([], ['dateApplication' => 'DESC']);
            // $nombreVehiculeMaximum = $nombreVehiculeMaximumRendezVousRepository->findOneBy([], ['dateApplication' => 'DESC']);
            $dansJoursMaximum = (clone $aujourdhui)
                ->modify('+' . $nombreJourMaximumRendezVous->getNombreJour() . ' days');

            if (
                $rdvExiste == null ||
                $rdvExiste->getDateRendezVous() < $aujourdhui ||
                $rdvExiste->getDateRendezVous() > $dansJoursMaximum ||
                ($rdvExiste->isConfirmation() == false && $rdvExiste->isAnnulationRendezVous() == true)
            ) {
                $entityManager->persist($rendezVou);
                $entityManager->flush();
            }
            // if ($rdvExiste != null && $rdvExiste->getDateRendezVous() >= $aujourdhui && $rdvExiste->getDateRendezVous() <= $dansJoursMaximum)

            return $this->redirectToRoute('app_recapitulation', [
                'code' => $code, // obligatoire pour remplir {code}
            ]);
        }

        return $this->render('selection_rendez_vous/remplissage_info.html.twig', [
            'form' => $form->createView(),
            'rendez_vou' => $rendezVou,
            'date' => $date,
            'time' => $time,
        ]);
    }

    #[Route('/rendez-vous/reserversubmitted', name: 'app_rdv_reserver_submitted', methods: ['GET', 'POST'])]
    public function reserverSubmitted(
        Request $request,
        NombreVehiculeMaximumRendezVousRepository $nombreVehiculeMaximumRendezVousRepository,
        NombreJourMaximumRendezVousRepository $nombreJourMaximumRendezVousRepository,
        RendezVousRepository $rendezVousRepository,
        EntityManagerInterface $entityManager)
    {
        //dump($request);
        $date = "";
        $time = "";
        if ($request->query->has('date')) {
            $date = $request->query->get('date');
        }
        if ($request->query->has('time')) {
            $time = $request->query->get('time');
        }
        $rendezVou = new RendezVous();
        if ($date != ""){
            $rendezVou->setDateRendezVous(new \DateTime($date));
        }
        if ($time != ""){
            $rendezVou->setHeureRendezVous(new \DateTime($time));
        }
        $form = $this->createForm(SelectionDateHeureType::class, $rendezVou, [
            'label' => false,
        ]);
        $form->handleRequest($request);
        //echo($time);

        /* if ($form->isSubmitted() && $form->isValid()) { */
        if ($form->isSubmitted() && $form->isValid()) {
            // $rendezVou = $request->query->all(); // ou $form->getData()
            // $rendezVou = $form->getData();
            echo("tonga eto");

            $code = uniqid();
            // resultat = $this->nettoyerTexte($texte);
            // strtoupper($texte);
            $rendezVou->setDatePriseRendezVous(new \DateTime());
            $rendezVou->setCodeRendezVous($code);
            $rendezVou->setAnnulationRendezVous(false);
            $rendezVou->setImmatriculation(
                strtoupper($this->nettoyerTexte($rendezVou->getImmatriculation()))
            );
            $rdvExiste = $rendezVousRepository->findOneBy([
                'immatriculation' => $rendezVou->getImmatriculation()
            ]);

            // $date = new ('2025-12-10'); // Exemple de date à tester
            $aujourdhui = new \DateTime(); // Aujourd'hui
            $nombreJourMaximumRendezVous = $nombreJourMaximumRendezVousRepository
                ->findOneBy([], ['dateApplication' => 'DESC']);
            // $nombreVehiculeMaximum = $nombreVehiculeMaximumRendezVousRepository->findOneBy([], ['dateApplication' => 'DESC']);
            $dansJoursMaximum = (clone $aujourdhui)
                ->modify('+' . $nombreJourMaximumRendezVous->getNombreJour() . ' days');

            if (
                $rdvExiste == null ||
                $rdvExiste->getDateRendezVous() < $aujourdhui ||
                $rdvExiste->getDateRendezVous() > $dansJoursMaximum ||
                ($rdvExiste->isConfirmation() == false && $rdvExiste->isAnnulationRendezVous() == true)
            ) {
                $entityManager->persist($rendezVou);
                $entityManager->flush();
            }
            // if ($rdvExiste != null && $rdvExiste->getDateRendezVous() >= $aujourdhui && $rdvExiste->getDateRendezVous() <= $dansJoursMaximum)

            return $this->redirectToRoute('app_recapitulation', [
                'code' => $code, // obligatoire pour remplir {code}
            ]);
        }

        return $this->render('selection_rendez_vous/remplissage_info.html.twig', [
            'form' => $form->createView(),
            'rendez_vou' => $rendezVou,
            'date' => $rendezVou->getDateRendezVous(),
            'time' => $rendezVou->getHeureRendezVous(),
        ]);
    }

    #[Route('/rendez-vous/recapitulation/{code}', name: 'app_recapitulation', methods: ['GET', 'POST'])]
    public function recapitulation($code, Request $request, RendezVousRepository $rendezVousRepository, EntityManagerInterface $entityManager)
    {
        $rendezVou = $rendezVousRepository->findOneBy(['codeRendezVous' => $code]);

        return $this->render('selection_rendez_vous/recapitulatif.html.twig', [
            'rendez_vou' => $rendezVou,
            'code' => $code,
        ]);
    }

    #[Route('/rendez-vous/imprimable/{code}', name: 'app_generate_pdf')]
    public function generate($code, Request $request, RendezVousRepository $rendezVousRepository, EntityManagerInterface $entityManager, PdfService $pdfService): Response
    {
        $rendezVou = $rendezVousRepository->findOneBy(['codeRendezVous' => $code]);

        $html = $this->renderView('selection_rendez_vous/imprimable.html.twig', [
            'title' => 'Mon PDF',
            'date' => date('d/m/Y'),
            'rendez_vou' => $rendezVou,
        ]);

        // Génération et téléchargement du PDF
        return $pdfService->generatePdfFromHtml($html, 'mon_document.pdf', true);
    }

    #[Route('/rendez-vous/annulation/{code}', name: 'app_annulation', methods: ['GET', 'POST'])]
    public function annulation($code, Request $request, RendezVousRepository $rendezVousRepository, EntityManagerInterface $entityManager)
    {
        $rendezVou = $rendezVousRepository->findOneBy(['codeRendezVous' => $code]);
        $rendezVou->setAnnulationRendezVous(true);
        $rendezVou->setConfirmation(false);
        $entityManager->persist($rendezVou);
        $entityManager->flush();

        return $this->render('selection_rendez_vous/recapitulatif.html.twig', [
            'rendez_vou' => $rendezVou,
            'code' => $code,
        ]);
    }

    #[Route('/rendez-vous/consultation', name: 'app_consultation', methods: ['GET', 'POST'])]
    public function consultation(Request $request, RendezVousRepository $rendezVousRepository, EntityManagerInterface $entityManager)
    {
        $rendezVou = new RendezVous();
        $code = '';
        $immatriculation = '';
        $code = $request->request->get('codeRendezVous');
        $immatriculation = $request->request->get('immatriculation');
        if ($code != '' && $immatriculation != '') {
            $rendezVou = $rendezVousRepository->findOneBy(['codeRendezVous' => $code, 'immatriculation' => $immatriculation], ['datePriseRendezVous' => 'DESC']);
            if ($rendezVou != null && $rendezVou->getId() > 0){
                return $this->redirectToRoute('app_recapitulation', [
                    'code' => $rendezVou->getCodeRendezVous(),
                ]);
            }
        }
        return $this->render('selection_rendez_vous/consultation.html.twig', [
        ]);
    }

    #[Route('/rendez-vous/modification/{id}', name: 'app_modification', methods: ['GET', 'POST'])]
    public function modification(Request $request, RendezVous $rendezVou, RendezVousRepository $rendezVousRepository, EntityManagerInterface $entityManager)
    {
        $code = '';
        //$rendezVou = new RendezVous();

        $code = $request->query->get('code');
        $immatriculation = $request->query->get('immatriculation');
        /* if ($code != '') {
            $rendezVou = $rendezVousRepository->findOneBy([
                //'codeRendezVous' => '692fd7ede24f7',
                'codeRendezVous' => $code,
                'immatriculation' => $immatriculation
            ], [
                'datePriseRendezVous' => 'DESC'
            ]);
        } */
        // $rendezVou = new RendezVous();
        // $rendezVou->setDateRendezVous(new \DateTime($date));
        // $rendezVou->setHeureRendezVous(new \DateTime($time));
        $form = $this->createForm(SelectionDateHeureType::class, $rendezVou, [
            'label' => false,
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $code = uniqid();
            // $rendezVou->setDatePriseRendezVous(new \DateTime());
            // $rendezVou->setCodeRendezVous($code);
            //  $rendezVou->setAnnulationRendezVous(false);
            $code = $rendezVou->getCodeRendezVous();
            // $entityManager->persist($rendezVou);
            $entityManager->flush();

            return $this->redirectToRoute('app_recapitulation', [
                'code' => $rendezVou->getCodeRendezVous(), // obligatoire pour remplir {code}
            ]);
        }

        return $this->render('selection_rendez_vous/modification.html.twig', [
            'form' => $form->createView(),
            'rendez_vou' => $rendezVou,
            //'date' => $rendezVou->getDateRendezVous(),
            //'time' => $rendezVou->getHeureRendezVous(),
        ]);
        /* return $this->render('selection_rendez_vous/modification.html.twig', [
        ]); */
    }

    public function nettoyerTexte(string $texte): string {

        // Supprimer tous les caractères non-alphanumériques (hors lettres/chiffres)
        // et les espaces
        $texteNettoye = preg_replace('/[^a-zA-Z0-9]/', '', $texte);

        return $texteNettoye;
    }
}
