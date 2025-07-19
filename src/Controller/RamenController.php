<?php

namespace App\Controller;

use App\Entity\Ramen;
use App\Form\RamenType;
use App\Repository\RamenRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ramen')]
final class RamenController extends AbstractController
{
    #[Route(name: 'app_ramen_index', methods: ['GET'])]
    public function index(RamenRepository $ramenRepository): Response
    {
        return $this->render('ramen/index.html.twig', [
            'ramens' => $ramenRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ramen_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $raman = new Ramen();
        $form = $this->createForm(RamenType::class, $raman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($raman);
            $entityManager->flush();

            return $this->redirectToRoute('app_ramen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ramen/new.html.twig', [
            'raman' => $raman,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ramen_show', methods: ['GET'])]
    public function show(Ramen $raman): Response
    {
        return $this->render('ramen/show.html.twig', [
            'raman' => $raman,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_ramen_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ramen $raman, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RamenType::class, $raman);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ramen_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ramen/edit.html.twig', [
            'raman' => $raman,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_ramen_delete', methods: ['POST'])]
    public function delete(Request $request, Ramen $raman, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$raman->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($raman);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_ramen_index', [], Response::HTTP_SEE_OTHER);
    }
}
