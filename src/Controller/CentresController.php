<?php

namespace App\Controller;

use App\Entity\Centres;
use App\Form\CentresType;
use App\Repository\CentresRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/centres')]
final class CentresController extends AbstractController
{
    #[Route(name: 'app_centres_index', methods: ['GET'])]
    public function index(Request $request, CentresRepository $centresRepository, PaginatorInterface $paginator): Response
    {
        $query = $centresRepository->findAll();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('centres/index.html.twig', [
            'centres' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_centres_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $centre = new Centres();
        $form = $this->createForm(CentresType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($centre);
            $entityManager->flush();

            return $this->redirectToRoute('app_centres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('centres/new.html.twig', [
            'centre' => $centre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_centres_show', methods: ['GET'])]
    public function show(Centres $centre): Response
    {
        return $this->render('centres/show.html.twig', [
            'centre' => $centre,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_centres_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Centres $centre, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CentresType::class, $centre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_centres_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('centres/edit.html.twig', [
            'centre' => $centre,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_centres_delete', methods: ['POST'])]
    public function delete(Request $request, Centres $centre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centre->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($centre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_centres_index', [], Response::HTTP_SEE_OTHER);
    }
}
