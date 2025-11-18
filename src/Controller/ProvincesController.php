<?php

namespace App\Controller;

use App\Entity\Provinces;
use App\Form\ProvincesType;
use App\Repository\ProvincesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/provinces')]
final class ProvincesController extends AbstractController
{
    #[Route(name: 'app_provinces_index', methods: ['GET'])]
    public function index(ProvincesRepository $provincesRepository): Response
    {
        return $this->render('provinces/index.html.twig', [
            'provinces' => $provincesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_provinces_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $province = new Provinces();
        $form = $this->createForm(ProvincesType::class, $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($province);
            $entityManager->flush();

            return $this->redirectToRoute('app_provinces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('provinces/new.html.twig', [
            'province' => $province,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_provinces_show', methods: ['GET'])]
    public function show(Provinces $province): Response
    {
        return $this->render('provinces/show.html.twig', [
            'province' => $province,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_provinces_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Provinces $province, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProvincesType::class, $province);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_provinces_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('provinces/edit.html.twig', [
            'province' => $province,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_provinces_delete', methods: ['POST'])]
    public function delete(Request $request, Provinces $province, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$province->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($province);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_provinces_index', [], Response::HTTP_SEE_OTHER);
    }
}
