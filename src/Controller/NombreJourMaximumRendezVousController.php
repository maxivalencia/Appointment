<?php

namespace App\Controller;

use App\Entity\NombreJourMaximumRendezVous;
use App\Form\NombreJourMaximumRendezVousType;
use App\Repository\NombreJourMaximumRendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/nombre/jour/maximum/rendez/vous')]
final class NombreJourMaximumRendezVousController extends AbstractController
{
    #[Route(name: 'app_nombre_jour_maximum_rendez_vous_index', methods: ['GET'])]
    public function index(NombreJourMaximumRendezVousRepository $nombreJourMaximumRendezVousRepository): Response
    {
        return $this->render('nombre_jour_maximum_rendez_vous/index.html.twig', [
            'nombre_jour_maximum_rendez_vouses' => $nombreJourMaximumRendezVousRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nombre_jour_maximum_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nombreJourMaximumRendezVou = new NombreJourMaximumRendezVous();
        $form = $this->createForm(NombreJourMaximumRendezVousType::class, $nombreJourMaximumRendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nombreJourMaximumRendezVou);
            $entityManager->flush();

            return $this->redirectToRoute('app_nombre_jour_maximum_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nombre_jour_maximum_rendez_vous/new.html.twig', [
            'nombre_jour_maximum_rendez_vou' => $nombreJourMaximumRendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nombre_jour_maximum_rendez_vous_show', methods: ['GET'])]
    public function show(NombreJourMaximumRendezVous $nombreJourMaximumRendezVou): Response
    {
        return $this->render('nombre_jour_maximum_rendez_vous/show.html.twig', [
            'nombre_jour_maximum_rendez_vou' => $nombreJourMaximumRendezVou,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nombre_jour_maximum_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NombreJourMaximumRendezVous $nombreJourMaximumRendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NombreJourMaximumRendezVousType::class, $nombreJourMaximumRendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_nombre_jour_maximum_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nombre_jour_maximum_rendez_vous/edit.html.twig', [
            'nombre_jour_maximum_rendez_vou' => $nombreJourMaximumRendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nombre_jour_maximum_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request, NombreJourMaximumRendezVous $nombreJourMaximumRendezVou, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nombreJourMaximumRendezVou->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($nombreJourMaximumRendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_nombre_jour_maximum_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
}
