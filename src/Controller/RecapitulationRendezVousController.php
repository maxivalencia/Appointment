<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class RecapitulationRendezVousController extends AbstractController
{
    #[Route('/recapitulation/rendez/vous', name: 'app_recapitulation_rendez_vous')]
    public function index(): Response
    {
        return $this->render('recapitulation_rendez_vous/index.html.twig', [
            'controller_name' => 'RecapitulationRendezVousController',
        ]);
    }
}
