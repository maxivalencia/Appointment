<?php

namespace App\Controller;

use App\Entity\NombreVehiculeMaximumRendezVous;
use App\Form\NombreVehiculeMaximumRendezVousType;
use App\Repository\NombreVehiculeMaximumRendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/nombre/vehicule/maximum/rendez/vous')]
final class NombreVehiculeMaximumRendezVousController extends AbstractController
{
    #[Route(name: 'app_nombre_vehicule_maximum_rendez_vous_index', methods: ['GET'])]
    public function index(NombreVehiculeMaximumRendezVousRepository $nombreVehiculeMaximumRendezVousRepository): Response
    {
        return $this->render('nombre_vehicule_maximum_rendez_vous/index.html.twig', [
            'nombre_vehicule_maximum_rendez_vouses' => $nombreVehiculeMaximumRendezVousRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nombre_vehicule_maximum_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nombreVehiculeMaximumRendezVou = new NombreVehiculeMaximumRendezVous();
        $form = $this->createForm(NombreVehiculeMaximumRendezVousType::class, $nombreVehiculeMaximumRendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nombreVehiculeMaximumRendezVou);
            $entityManager->flush();

            return $this->redirectToRoute('app_nombre_vehicule_maximum_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nombre_vehicule_maximum_rendez_vous/new.html.twig', [
            'nombre_vehicule_maximum_rendez_vou' => $nombreVehiculeMaximumRendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nombre_vehicule_maximum_rendez_vous_show', methods: ['GET'])]
    public function show(NombreVehiculeMaximumRendezVous $nombreVehiculeMaximumRendezVou): Response
    {
        return $this->render('nombre_vehicule_maximum_rendez_vous/show.html.twig', [
            'nombre_vehicule_maximum_rendez_vou' => $nombreVehiculeMaximumRendezVou,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nombre_vehicule_maximum_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NombreVehiculeMaximumRendezVous $nombreVehiculeMaximumRendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NombreVehiculeMaximumRendezVousType::class, $nombreVehiculeMaximumRendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_nombre_vehicule_maximum_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nombre_vehicule_maximum_rendez_vous/edit.html.twig', [
            'nombre_vehicule_maximum_rendez_vou' => $nombreVehiculeMaximumRendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nombre_vehicule_maximum_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request, NombreVehiculeMaximumRendezVous $nombreVehiculeMaximumRendezVou, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nombreVehiculeMaximumRendezVou->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($nombreVehiculeMaximumRendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_nombre_vehicule_maximum_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
}
