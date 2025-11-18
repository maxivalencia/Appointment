<?php

namespace App\Controller;

use App\Entity\OuvertureSamedi;
use App\Form\OuvertureSamediType;
use App\Repository\OuvertureSamediRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/ouverture/samedi')]
final class OuvertureSamediController extends AbstractController
{
    #[Route(name: 'app_ouverture_samedi_index', methods: ['GET'])]
    public function index(Request $request, OuvertureSamediRepository $ouvertureSamediRepository, PaginatorInterface $paginator): Response
    {
        $query = $ouvertureSamediRepository->findAll();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('ouverture_samedi/index.html.twig', [
            'ouverture_samedis' => $pagination,
        ]);
    }

    #[Route('/new', name: 'app_ouverture_samedi_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $ouvertureSamedi = new OuvertureSamedi();
        $form = $this->createForm(OuvertureSamediType::class, $ouvertureSamedi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ouvertureSamedi);
            $entityManager->flush();

            return $this->redirectToRoute('app_ouverture_samedi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ouverture_samedi/new.html.twig', [
            'ouverture_samedi' => $ouvertureSamedi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ouverture_samedi_show', methods: ['GET'])]
    public function show(OuvertureSamedi $ouvertureSamedi): Response
    {
        return $this->render('ouverture_samedi/show.html.twig', [
            'ouverture_samedi' => $ouvertureSamedi,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ouverture_samedi_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, OuvertureSamedi $ouvertureSamedi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OuvertureSamediType::class, $ouvertureSamedi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ouverture_samedi_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ouverture_samedi/edit.html.twig', [
            'ouverture_samedi' => $ouvertureSamedi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ouverture_samedi_delete', methods: ['POST'])]
    public function delete(Request $request, OuvertureSamedi $ouvertureSamedi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ouvertureSamedi->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($ouvertureSamedi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ouverture_samedi_index', [], Response::HTTP_SEE_OTHER);
    }
}
