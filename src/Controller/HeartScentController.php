<?php

namespace App\Controller;

use App\Entity\HeartScent;
use App\Form\HeartScentType;
use App\Repository\HeartScentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/heart/scent')]
class HeartScentController extends AbstractController
{
    #[Route('/', name: 'app_heart_scent_index', methods: ['GET'])]
    public function index(HeartScentRepository $heartScentRepository): Response
    {
        return $this->render('heart_scent/index.html.twig', [
            'heart_scents' => $heartScentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_heart_scent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HeartScentRepository $heartScentRepository): Response
    {
        $heartScent = new HeartScent();
        $form = $this->createForm(HeartScentType::class, $heartScent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $heartScentRepository->save($heartScent, true);

            return $this->redirectToRoute('app_heart_scent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('heart_scent/new.html.twig', [
            'heart_scent' => $heartScent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_heart_scent_show', methods: ['GET'])]
    public function show(HeartScent $heartScent): Response
    {
        return $this->render('heart_scent/show.html.twig', [
            'heart_scent' => $heartScent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_heart_scent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HeartScent $heartScent, HeartScentRepository $heartScentRepository): Response
    {
        $form = $this->createForm(HeartScentType::class, $heartScent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $heartScentRepository->save($heartScent, true);

            return $this->redirectToRoute('app_heart_scent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('heart_scent/edit.html.twig', [
            'heart_scent' => $heartScent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_heart_scent_delete', methods: ['POST'])]
    public function delete(Request $request, HeartScent $heartScent, HeartScentRepository $heartScentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$heartScent->getId(), $request->request->get('_token'))) {
            $heartScentRepository->remove($heartScent, true);
        }

        return $this->redirectToRoute('app_heart_scent_index', [], Response::HTTP_SEE_OTHER);
    }
}
