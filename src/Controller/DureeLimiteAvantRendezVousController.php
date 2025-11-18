<?php

namespace App\Controller;

use App\Entity\DureeLimiteAvantRendezVous;
use App\Form\DureeLimiteAvantRendezVousType;
use App\Repository\DureeLimiteAvantRendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/duree/limite/avant/rendez/vous')]
final class DureeLimiteAvantRendezVousController extends AbstractController
{
    #[Route(name: 'app_duree_limite_avant_rendez_vous_index', methods: ['GET'])]
    public function index(Request $request, DureeLimiteAvantRendezVousRepository $dureeLimiteAvantRendezVousRepository, PaginatorInterface $paginator): Response
    {
        $query = $dureeLimiteAvantRendezVousRepository->findAll();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('duree_limite_avant_rendez_vous/index.html.twig', [
            'duree_limite_avant_rendez_vouses' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_duree_limite_avant_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $dureeLimiteAvantRendezVou = new DureeLimiteAvantRendezVous();
        $form = $this->createForm(DureeLimiteAvantRendezVousType::class, $dureeLimiteAvantRendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dureeLimiteAvantRendezVou);
            $entityManager->flush();

            return $this->redirectToRoute('app_duree_limite_avant_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('duree_limite_avant_rendez_vous/new.html.twig', [
            'duree_limite_avant_rendez_vou' => $dureeLimiteAvantRendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_duree_limite_avant_rendez_vous_show', methods: ['GET'])]
    public function show(DureeLimiteAvantRendezVous $dureeLimiteAvantRendezVou): Response
    {
        return $this->render('duree_limite_avant_rendez_vous/show.html.twig', [
            'duree_limite_avant_rendez_vou' => $dureeLimiteAvantRendezVou,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_duree_limite_avant_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DureeLimiteAvantRendezVous $dureeLimiteAvantRendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DureeLimiteAvantRendezVousType::class, $dureeLimiteAvantRendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_duree_limite_avant_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('duree_limite_avant_rendez_vous/edit.html.twig', [
            'duree_limite_avant_rendez_vou' => $dureeLimiteAvantRendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_duree_limite_avant_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request, DureeLimiteAvantRendezVous $dureeLimiteAvantRendezVou, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dureeLimiteAvantRendezVou->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($dureeLimiteAvantRendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_duree_limite_avant_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
}
