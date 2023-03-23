<?php

namespace App\Controller;

use App\Entity\CreatedPerfume;
use App\Form\CreatedPerfumeType;
use App\Entity\ProductQuantities;
use App\Repository\ProductRepository;
use App\Repository\BaseScentRepository;
use App\Repository\HeadScentRepository;
use App\Repository\HeartScentRepository;
use App\Repository\CreatedPerfumeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductQuantitiesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Serializer;

#[Route('/created/perfume')]
class CreatedPerfumeController extends AbstractController
{
    
    #[Route('/', name: 'app_created_perfume_index', methods: ['GET'])]
    public function index(CreatedPerfumeRepository $createdPerfumeRepository, ProductRepository $productRepository, ProductQuantitiesRepository $productQuantitiesRepository, UserInterface $user, BaseScentRepository $baseScentRepository, HeartScentRepository $heartScentRepository, HeadScentRepository $headScentRepository): Response
    {
        return $this->render('created_perfume/index.html.twig', [
            'head_scents' => $headScentRepository->findAll(),
            'heart_scents' => $heartScentRepository->findAll(),
            'base_scents' => $baseScentRepository->findAll(),
            'products' => $productRepository->findAll(),
            'created_perfumes' => $createdPerfumeRepository->findBy(['user' => $user->getId()]),
            'product_quantities_per_perfume' => $productQuantitiesRepository->findBy(['user' => $user])
        ]);
    }

    #[Route('/new', name: 'app_created_perfume_new', methods: ['GET', 'POST'])]
    public function new(Request $request, UserInterface $user, ProductQuantitiesRepository $productQuantitiesRepository, BaseScentRepository $baseScentRepository, HeartScentRepository $heartScentRepository, HeadScentRepository $headScentRepository, CreatedPerfumeRepository $createdPerfumeRepository, ProductRepository $productRepository): Response
    {
        $createdPerfume = new CreatedPerfume();
        $productQuantities = new ProductQuantities();
        $form = $this->createForm(CreatedPerfumeType::class, $createdPerfume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quantities = array_filter($request->get('product_quantity'));
            $productId = $request->get('product_id');
            $product = $request->get('product');

            $createdPerfume->setUser($user);
            $createdPerfumeRepository->save($createdPerfume, true);

            $productQuantities->setCreatedPerfume($createdPerfume);
            $productQuantities->setQuantities(array_values($quantities));
            $productQuantities->setUser($user);
            $productQuantitiesRepository->save($productQuantities, true);

            foreach($quantities as $key => $quantity) {
                $product = $productRepository->findOneBy(['id' => $productId[$key]]);
                $createdPerfume->addProduct($product);
                $productQuantities->addProduct($product);
                $createdPerfumeRepository->save($createdPerfume,true);
                $productQuantitiesRepository->save($productQuantities,true);
            }

            return $this->redirectToRoute('app_created_perfume_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('created_perfume/new.html.twig', [
            'products' => $productRepository->findAll(),
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
    public function edit(Request $request, UserInterface $user, ProductQuantitiesRepository $productQuantitiesRepository, ProductRepository $productRepository, CreatedPerfume $createdPerfume, CreatedPerfumeRepository $createdPerfumeRepository, BaseScentRepository $baseScentRepository, HeartScentRepository $heartScentRepository, HeadScentRepository $headScentRepository): Response
    {
        $form = $this->createForm(CreatedPerfumeType::class, $createdPerfume);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quantities = array_filter($request->get('product_quantity'));
            $productId = $request->get('product_id');
            $product = $request->get('product');

            $productQuantities = $productQuantitiesRepository->findOneBy(['createdPerfume'=> $createdPerfume, 'user' => $user]);
            if (!$productQuantities) {
                $productQuantities = new ProductQuantities();
                $productQuantities->setUser($user);
            }

            $productQuantities->setCreatedPerfume($createdPerfume);
            $productQuantities->setQuantities(array_values($quantities));
            $productQuantitiesRepository->save($productQuantities, true);

            $initial_products = $createdPerfume->getProducts();
            foreach($initial_products as $product) {
                $createdPerfume->removeProduct($product);
                if (!empty($productQuantities->getProducts()["elements"])){
                    $productQuantities->removeProduct($product);
                }
            }

            foreach($quantities as $key => $quantity) {
                $product = $productRepository->findOneBy(['id' => $productId[$key]]);
                $createdPerfume->addProduct($product);
                $productQuantities->addProduct($product);
                $createdPerfumeRepository->save($createdPerfume,true);
                $productQuantitiesRepository->save($productQuantities,true);
            }

            return $this->redirectToRoute('app_created_perfume_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('created_perfume/edit.html.twig', [
            'head_scents' => $headScentRepository->findAll(),
            'heart_scents' => $heartScentRepository->findAll(),
            'base_scents' => $baseScentRepository->findAll(),
            'product_quantities' => $productQuantitiesRepository->findOneBy(['createdPerfume'=> $createdPerfume, 'user' => $user]),
            'products' => $productRepository->findAll(),
            'created_perfume' => $createdPerfume,
            'form' => $form
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
