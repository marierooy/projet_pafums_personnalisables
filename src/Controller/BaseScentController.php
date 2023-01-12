<?php

namespace App\Controller;

use App\Entity\BaseScent;
use App\Form\BaseScentType;
use App\Repository\BaseScentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/base/scent')]
class BaseScentController extends AbstractController
{
    #[Route('/', name: 'app_base_scent_index', methods: ['GET'])]
    public function index(BaseScentRepository $baseScentRepository): Response
    {
        return $this->render('base_scent/index.html.twig', [
            'base_scents' => $baseScentRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_base_scent_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BaseScentRepository $baseScentRepository): Response
    {
        $baseScent = new BaseScent();
        $form = $this->createForm(BaseScentType::class, $baseScent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $baseScentRepository->save($baseScent, true);

            return $this->redirectToRoute('app_base_scent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('base_scent/new.html.twig', [
            'base_scent' => $baseScent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_base_scent_show', methods: ['GET'])]
    public function show(BaseScent $baseScent): Response
    {
        return $this->render('base_scent/show.html.twig', [
            'base_scent' => $baseScent,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_base_scent_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BaseScent $baseScent, BaseScentRepository $baseScentRepository): Response
    {
        $form = $this->createForm(BaseScentType::class, $baseScent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $baseScentRepository->save($baseScent, true);

            return $this->redirectToRoute('app_base_scent_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('base_scent/edit.html.twig', [
            'base_scent' => $baseScent,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_base_scent_delete', methods: ['POST'])]
    public function delete(Request $request, BaseScent $baseScent, BaseScentRepository $baseScentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$baseScent->getId(), $request->request->get('_token'))) {
            $baseScentRepository->remove($baseScent, true);
        }

        return $this->redirectToRoute('app_base_scent_index', [], Response::HTTP_SEE_OTHER);
    }
}
