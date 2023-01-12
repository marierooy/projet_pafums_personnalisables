<?php

namespace App\Controller;

use App\Entity\ReproducedPerfume;
use App\Form\ReproducedPerfumeType;
use App\Repository\ReproducedPerfumeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reproduced/perfume')]
class ReproducedPerfumeController extends AbstractController
{
    #[Route('/', name: 'app_reproduced_perfume_index', methods: ['GET'])]
    public function index(ReproducedPerfumeRepository $reproducedPerfumeRepository): Response
    {
        return $this->render('reproduced_perfume/index.html.twig', [
            'reproduced_perfumes' => $reproducedPerfumeRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reproduced_perfume_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReproducedPerfumeRepository $reproducedPerfumeRepository): Response
    {
        $reproducedPerfume = new ReproducedPerfume();
        $form = $this->createForm(ReproducedPerfumeType::class, $reproducedPerfume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reproducedPerfumeRepository->save($reproducedPerfume, true);

            return $this->redirectToRoute('app_reproduced_perfume_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reproduced_perfume/new.html.twig', [
            'reproduced_perfume' => $reproducedPerfume,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reproduced_perfume_show', methods: ['GET'])]
    public function show(ReproducedPerfume $reproducedPerfume): Response
    {
        return $this->render('reproduced_perfume/show.html.twig', [
            'reproduced_perfume' => $reproducedPerfume,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reproduced_perfume_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReproducedPerfume $reproducedPerfume, ReproducedPerfumeRepository $reproducedPerfumeRepository): Response
    {
        $form = $this->createForm(ReproducedPerfumeType::class, $reproducedPerfume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reproducedPerfumeRepository->save($reproducedPerfume, true);

            return $this->redirectToRoute('app_reproduced_perfume_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reproduced_perfume/edit.html.twig', [
            'reproduced_perfume' => $reproducedPerfume,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reproduced_perfume_delete', methods: ['POST'])]
    public function delete(Request $request, ReproducedPerfume $reproducedPerfume, ReproducedPerfumeRepository $reproducedPerfumeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reproducedPerfume->getId(), $request->request->get('_token'))) {
            $reproducedPerfumeRepository->remove($reproducedPerfume, true);
        }

        return $this->redirectToRoute('app_reproduced_perfume_index', [], Response::HTTP_SEE_OTHER);
    }
}
