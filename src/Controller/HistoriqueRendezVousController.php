<?php

namespace App\Controller;

use App\Entity\HistoriqueRendezVous;
use App\Form\HistoriqueRendezVousType;
use App\Repository\HistoriqueRendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/historique/rendez/vous')]
final class HistoriqueRendezVousController extends AbstractController
{
    #[Route(name: 'app_historique_rendez_vous_index', methods: ['GET'])]
    public function index(Request $request, HistoriqueRendezVousRepository $historiqueRendezVousRepository, PaginatorInterface $paginator): Response
    {
        $query = $historiqueRendezVousRepository->findAll();

        $pagination = $paginator->paginate(
            $query,                              
            $request->query->getInt('page', 1),  
            10                                   
        );
        return $this->render('historique_rendez_vous/index.html.twig', [
            'historique_rendez_vouses' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_historique_rendez_vous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $historiqueRendezVou = new HistoriqueRendezVous();
        $form = $this->createForm(HistoriqueRendezVousType::class, $historiqueRendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($historiqueRendezVou);
            $entityManager->flush();

            return $this->redirectToRoute('app_historique_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('historique_rendez_vous/new.html.twig', [
            'historique_rendez_vou' => $historiqueRendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_historique_rendez_vous_show', methods: ['GET'])]
    public function show(HistoriqueRendezVous $historiqueRendezVou): Response
    {
        return $this->render('historique_rendez_vous/show.html.twig', [
            'historique_rendez_vou' => $historiqueRendezVou,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_historique_rendez_vous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HistoriqueRendezVous $historiqueRendezVou, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(HistoriqueRendezVousType::class, $historiqueRendezVou);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_historique_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('historique_rendez_vous/edit.html.twig', [
            'historique_rendez_vou' => $historiqueRendezVou,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_historique_rendez_vous_delete', methods: ['POST'])]
    public function delete(Request $request, HistoriqueRendezVous $historiqueRendezVou, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$historiqueRendezVou->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($historiqueRendezVou);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_historique_rendez_vous_index', [], Response::HTTP_SEE_OTHER);
    }
}
