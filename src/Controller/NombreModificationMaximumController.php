<?php

namespace App\Controller;

use App\Entity\NombreModificationMaximum;
use App\Form\NombreModificationMaximumType;
use App\Repository\NombreModificationMaximumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/nombre/modification/maximum')]
final class NombreModificationMaximumController extends AbstractController
{
    #[Route(name: 'app_nombre_modification_maximum_index', methods: ['GET'])]
    public function index(NombreModificationMaximumRepository $nombreModificationMaximumRepository): Response
    {
        return $this->render('nombre_modification_maximum/index.html.twig', [
            'nombre_modification_maximums' => $nombreModificationMaximumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_nombre_modification_maximum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $nombreModificationMaximum = new NombreModificationMaximum();
        $form = $this->createForm(NombreModificationMaximumType::class, $nombreModificationMaximum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($nombreModificationMaximum);
            $entityManager->flush();

            return $this->redirectToRoute('app_nombre_modification_maximum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nombre_modification_maximum/new.html.twig', [
            'nombre_modification_maximum' => $nombreModificationMaximum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nombre_modification_maximum_show', methods: ['GET'])]
    public function show(NombreModificationMaximum $nombreModificationMaximum): Response
    {
        return $this->render('nombre_modification_maximum/show.html.twig', [
            'nombre_modification_maximum' => $nombreModificationMaximum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nombre_modification_maximum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, NombreModificationMaximum $nombreModificationMaximum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(NombreModificationMaximumType::class, $nombreModificationMaximum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_nombre_modification_maximum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nombre_modification_maximum/edit.html.twig', [
            'nombre_modification_maximum' => $nombreModificationMaximum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nombre_modification_maximum_delete', methods: ['POST'])]
    public function delete(Request $request, NombreModificationMaximum $nombreModificationMaximum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$nombreModificationMaximum->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($nombreModificationMaximum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_nombre_modification_maximum_index', [], Response::HTTP_SEE_OTHER);
    }
}
