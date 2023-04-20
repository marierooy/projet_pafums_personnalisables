<?php

namespace App\Controller;

use Datetime;
use App\Entity\PurchasedProduct;
use Doctrine\ORM\Mapping\Entity;
use App\Form\PurchasedProductType;
use App\Repository\UserRepository;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use App\Repository\CreatedPerfumeRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\PurchasedProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/purchased/product')]
class PurchasedProductController extends AbstractController
{
    #[Route('/', name: 'app_purchased_product_index_user', methods: ['GET'])]
    public function index_user(Request $request, ProductRepository $productRepository, CreatedPerfumeRepository $createdPerfumeRepository, PurchasedProductRepository $purchasedProductRepository, OrderRepository $orderRepository, UserInterface $user): Response
    {
        $filterPurchasedProduct = [];
        $product_id = $request->get('product_id');
        if (!empty($product_id)) {
            $filterPurchasedProduct['product'] = $product_id;
        }

        $created_perfumes_id = $request->get('created_perfume_id');

        $created_at_init = $request->get('created_at_init');
        $created_at_final = $request->get('created_at_final');

        if(!empty($created_at_init) && !empty($created_at_final)) {  
           $orders = $orderRepository->findByDate($created_at_init, $created_at_final, $user->getId());
        } else {
            $orders = $orderRepository->findby(['user' => $user->getId()]);

        }
        return $this->render('purchased_product/index_user.html.twig', [
            'created_perfume_id' => $created_perfumes_id,
            'created_perfumes' => $createdPerfumeRepository->findby(['user' => $user->getId()]),
            'orders' => $orders,
            'purchased_products' => $purchasedProductRepository->findBy($filterPurchasedProduct),
            'products' => $productRepository->findall(),
        ]);
    }

    #[Route('/admin', name: 'app_purchased_product_index_admin', methods: ['GET'])]
    public function index_admin(Request $request, ProductRepository $productRepository, CreatedPerfumeRepository $createdPerfumeRepository, UserRepository $userRepository, PurchasedProductRepository $purchasedProductRepository, OrderRepository $orderRepository, UserInterface $user): Response
    {
        $filterOrder = [];
        $user_id = $request->get('user_id');
        if (!empty($user_id)) {
            $filterOrder['user'] = $user_id;
        }

        $filterPurchasedProduct = [];
        $product_id = $request->get('product_id');
        if (!empty($product_id)) {
            $filterPurchasedProduct['product'] = $product_id;
        }

        $created_at_init = $request->get('created_at_init');
        $created_at_final = $request->get('created_at_final');

        if(!empty($created_at_init) && !empty($created_at_final)) {  
           $orders = $orderRepository->findByDate($created_at_init, $created_at_final);
        } else {
            $orders = $orderRepository->findBy($filterOrder);

        }

        return $this->render('purchased_product/index_admin.html.twig', [
            'products' => $productRepository->findall(),
            'created_perfumes' => $createdPerfumeRepository->findall(),
            'orders' => $orders,
            'purchased_products' => $purchasedProductRepository->findBy($filterPurchasedProduct),
            'users' => $userRepository->findall(),
        ]);
    }
}
