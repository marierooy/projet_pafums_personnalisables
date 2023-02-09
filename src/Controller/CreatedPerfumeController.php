<?php

namespace App\Controller;

use App\Entity\CreatedPerfume;
use App\Form\CreatedPerfumeType;
use App\Repository\ProductRepository;
use App\Repository\BaseScentRepository;
use App\Repository\HeadScentRepository;
use App\Repository\HeartScentRepository;
use App\Repository\CreatedPerfumeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/created/perfume')]
class CreatedPerfumeController extends AbstractController
{
    
    #[Route('/', name: 'app_created_perfume_index', methods: ['GET'])]
    public function index(CreatedPerfumeRepository $createdPerfumeRepository, UserInterface $user, BaseScentRepository $baseScentRepository, HeartScentRepository $heartScentRepository, HeadScentRepository $headScentRepository): Response
    {
        return $this->render('created_perfume/index.html.twig', [
            'head_scents' => $headScentRepository->findAll(),
            'heart_scents' => $heartScentRepository->findAll(),
            'base_scents' => $baseScentRepository->findAll(),
            'created_perfumes' => $createdPerfumeRepository->findBy(['user' => $user->getId()]),
        ]);
    }

    #[Route('/new', name: 'app_created_perfume_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserInterface $user, BaseScentRepository $baseScentRepository, HeartScentRepository $heartScentRepository, HeadScentRepository $headScentRepository, CreatedPerfumeRepository $createdPerfumeRepository, ProductRepository $productRepository): Response
    {
        $createdPerfume = new CreatedPerfume();
        $form = $this->createForm(CreatedPerfumeType::class, $createdPerfume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createdPerfume->setUser($user);
            $createdPerfumeRepository->save($createdPerfume, true);

            foreach($request->get('created_perfume')['products'] as $product_id) {
                $product = $productRepository->findOneBy(['id' => $product_id]);
                $createdPerfume->addProduct($product);
                $createdPerfumeRepository->save($createdPerfume,true);
            }

            return $this->redirectToRoute('app_created_perfume_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('created_perfume/new.html.twig', [
            'head_scents' => $headScentRepository->findAll(),
            'heart_scents' => $heartScentRepository->findAll(),
            'base_scents' => $baseScentRepository->findAll(),
            'created_perfume' => $createdPerfume,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_created_perfume_show', methods: ['GET'])]
    public function show(CreatedPerfume $createdPerfume): Response
    {
        return $this->render('created_perfume/show.html.twig', [
            'created_perfume' => $createdPerfume,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_created_perfume_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CreatedPerfume $createdPerfume, CreatedPerfumeRepository $createdPerfumeRepository, BaseScentRepository $baseScentRepository, HeartScentRepository $heartScentRepository, HeadScentRepository $headScentRepository): Response
    {
        $form = $this->createForm(CreatedPerfumeType::class, $createdPerfume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $createdPerfumeRepository->save($createdPerfume, true);

            return $this->redirectToRoute('app_created_perfume_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('created_perfume/edit.html.twig', [
            'head_scents' => $headScentRepository->findAll(),
            'heart_scents' => $heartScentRepository->findAll(),
            'base_scents' => $baseScentRepository->findAll(),
            'created_perfume' => $createdPerfume,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_created_perfume_delete', methods: ['POST'])]
    public function delete(Request $request, CreatedPerfume $createdPerfume, CreatedPerfumeRepository $createdPerfumeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$createdPerfume->getId(), $request->request->get('_token'))) {
            $createdPerfumeRepository->remove($createdPerfume, true);
        }

        return $this->redirectToRoute('app_created_perfume_index', [], Response::HTTP_SEE_OTHER);
    }
}
