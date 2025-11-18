<?php

namespace App\Controller;

use App\Entity\NombreRendezVousParHeure;
use App\Form\NombreRendezVousParHeureType;
use App\Repository\NombreRendezVousParHeureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/nombre/rendez/vous/par/heure')]
final class NombreRendezVousParHeureController extends AbstractController
{
    #[Route(name: 'app_nombre_rendez_vous_par_heure_index', methods: ['GET'])]
    public function index(Request $request, NombreRendezVousParHeureRepository $nombreRendezVousParHeureRepository, PaginatorInterface $paginator): Response
    {
        $query = $nombreRendezVousParHeureRepository->findAll();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('nombre_rendez_vous_par_heure/index.html.twig', [
            'nombre_rendez_vous_par_heures' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_nombre_rendez_vous_par_heure_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nombreRendezVousParHeure = new NombreRendezVousParHeure();
        $form = $this->createForm(NombreRendezVousParHeureType::class, $nombreRendezVousParHeure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nombreRendezVousParHeure);
            $entityManager->flush();

            return $this->redirectToRoute('app_nombre_rendez_vous_par_heure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nombre_rendez_vous_par_heure/new.html.twig', [
            'nombre_rendez_vous_par_heure' => $nombreRendezVousParHeure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nombre_rendez_vous_par_heure_show', methods: ['GET'])]
    public function show(NombreRendezVousParHeure $nombreRendezVousParHeure): Response
    {
        return $this->render('nombre_rendez_vous_par_heure/show.html.twig', [
            'nombre_rendez_vous_par_heure' => $nombreRendezVousParHeure,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nombre_rendez_vous_par_heure_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NombreRendezVousParHeure $nombreRendezVousParHeure, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NombreRendezVousParHeureType::class, $nombreRendezVousParHeure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_nombre_rendez_vous_par_heure_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nombre_rendez_vous_par_heure/edit.html.twig', [
            'nombre_rendez_vous_par_heure' => $nombreRendezVousParHeure,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nombre_rendez_vous_par_heure_delete', methods: ['POST'])]
    public function delete(Request $request, NombreRendezVousParHeure $nombreRendezVousParHeure, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nombreRendezVousParHeure->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($nombreRendezVousParHeure);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_nombre_rendez_vous_par_heure_index', [], Response::HTTP_SEE_OTHER);
    }
}
