<?php

namespace App\Controller;

use App\Entity\JourSpeciale;
use App\Form\JourSpecialeType;
use App\Repository\JourSpecialeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/jour/speciale')]
final class JourSpecialeController extends AbstractController
{
    #[Route(name: 'app_jour_speciale_index', methods: ['GET'])]
    public function index(JourSpecialeRepository $jourSpecialeRepository): Response
    {
        return $this->render('jour_speciale/index.html.twig', [
            'jour_speciales' => $jourSpecialeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_jour_speciale_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $jourSpeciale = new JourSpeciale();
        $form = $this->createForm(JourSpecialeType::class, $jourSpeciale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($jourSpeciale);
            $entityManager->flush();

            return $this->redirectToRoute('app_jour_speciale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jour_speciale/new.html.twig', [
            'jour_speciale' => $jourSpeciale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_jour_speciale_show', methods: ['GET'])]
    public function show(JourSpeciale $jourSpeciale): Response
    {
        return $this->render('jour_speciale/show.html.twig', [
            'jour_speciale' => $jourSpeciale,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_jour_speciale_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, JourSpeciale $jourSpeciale, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(JourSpecialeType::class, $jourSpeciale);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_jour_speciale_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('jour_speciale/edit.html.twig', [
            'jour_speciale' => $jourSpeciale,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_jour_speciale_delete', methods: ['POST'])]
    public function delete(Request $request, JourSpeciale $jourSpeciale, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$jourSpeciale->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($jourSpeciale);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_jour_speciale_index', [], Response::HTTP_SEE_OTHER);
    }
}
