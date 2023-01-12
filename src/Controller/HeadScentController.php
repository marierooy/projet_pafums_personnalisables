<?php

namespace App\Controller;

use App\Entity\HeadScent;
use App\Form\HeadScentType;
use App\Repository\HeadScentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/head/scent')]
class HeadScentController extends AbstractController
{
    #[Route('/', name: 'app_head_scent_index', methods: ['GET'])]
    public function index(HeadScentRepository $headScentRepository): Response
    {
        return $this->render('head_scent/index.html.twig', [
            'head_scents' => $headScentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_head_scent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HeadScentRepository $headScentRepository): Response
    {
        $headScent = new HeadScent();
        $form = $this->createForm(HeadScentType::class, $headScent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $headScentRepository->save($headScent, true);

            return $this->redirectToRoute('app_head_scent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('head_scent/new.html.twig', [
            'head_scent' => $headScent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_head_scent_show', methods: ['GET'])]
    public function show(HeadScent $headScent): Response
    {
        return $this->render('head_scent/show.html.twig', [
            'head_scent' => $headScent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_head_scent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HeadScent $headScent, HeadScentRepository $headScentRepository): Response
    {
        $form = $this->createForm(HeadScentType::class, $headScent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $headScentRepository->save($headScent, true);

            return $this->redirectToRoute('app_head_scent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('head_scent/edit.html.twig', [
            'head_scent' => $headScent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_head_scent_delete', methods: ['POST'])]
    public function delete(Request $request, HeadScent $headScent, HeadScentRepository $headScentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$headScent->getId(), $request->request->get('_token'))) {
            $headScentRepository->remove($headScent, true);
        }

        return $this->redirectToRoute('app_head_scent_index', [], Response::HTTP_SEE_OTHER);
    }
}
