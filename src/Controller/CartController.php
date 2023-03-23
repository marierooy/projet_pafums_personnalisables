<?php

namespace App\Controller;

use App\Entity\Order;
use DatetimeImmutable;
use App\Entity\Product;
use Psr\Log\LoggerInterface;
use App\Entity\CreatedPerfume;
use App\Entity\PurchasedProduct;
use App\Repository\ProductRepository;
use App\Repository\BaseScentRepository;
use App\Repository\HeadScentRepository;
use App\Repository\HeartScentRepository;
use App\Repository\CreatedPerfumeRepository;
use App\Repository\OrderRepository as OrderR;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\ProductQuantitiesRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\PurchasedProductRepository as PPR;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $session;

    public function __construct(RequestStack $requestStack) {
        $this->session = $requestStack->getSession();
    }
    
    #[Route('/cart', name: 'app_cart')]
    public function index(CreatedPerfumeRepository $createdPerfumeRepo, UserInterface $user, ProductQuantitiesRepository $productQuantitiesRepository, ProductRepository $productRepository): Response
    {
        $total = 0;
        $perfumes = [];
        $allProductQuantities = [];
        $products = $productRepository->findAll();
        if (!is_null($this->session->get('cart'))) {
            foreach($this->session->get('cart') as $createdPerfume) {
                /*$headScentId = $createdPerfume['entity']->getHeadScent()->getId();
                $heartScentId = $createdPerfume['entity']->getHeartScent()->getId();
                $baseScentId = $createdPerfume['entity']->getBaseScent()->getId();
                $headScent = $headScentRepo->findOneBy(['id' => $headScentId]);*/

                $createdPerfume = $createdPerfumeRepo->findOneBy(['id' => $createdPerfume['entity']->getId()]);
                $productQuantities = $productQuantitiesRepository->findOneBy(['createdPerfume'=> $createdPerfume, 'user' => $user]);

                $perfumes[] = $createdPerfume;
                $allProductQuantities[] = $productQuantities;

                foreach($createdPerfume->getProducts() as $product) {
                    foreach($products as $key => $productBis) {
                        if($product == $productBis) {
                            $selected_key = $key;
                        } 
                    }
                    $total += $product->getPrice()*$productQuantities->getQuantities()[$selected_key];
                }

                //$total += $createdPerfume['entity']->getProducts()->getPrice() ?? 0;
            }
        }

        $this->session->set('total', $total);

        return $this->render('cart/index.html.twig', [
           'total' => $total,
           'perfumes' => $perfumes,
           'all_product_quantities'=> $allProductQuantities,
           'products' => $products

        ]);
    }

    #[Route('/addToCart/{id}', name: 'app_add_to_cart')]
    public function addToCartCreatedPerfume(Request $request, CreatedPerfume $createdPerfume): Response
    {
        $cart = $this->session->get('cart', []);
       
        if (empty($cart[$createdPerfume->getId()])) {
            $cart[$createdPerfume->getId()] = [
                'entity' => $createdPerfume,
                'quantity' => 1
            ];
        } else {
            $cart[$createdPerfume->getId()]['quantity']++;
        }
        
        $this->session->set('cart', $cart);

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }

     #[Route('/deleteFromCart/{id}', name: 'app_delete_from_cart')]
    public function deleteFromCart(Request $request, CreatedPerfume $createdPerfume): Response
    {
        $cart = $this->session->get('cart', []);
        
        unset($cart[$createdPerfume->getId()]);
        
        $this->session->set('cart', $cart);

        $route = $request->headers->get('referer');

        return $this->redirect($route);
    }

    #[Route('/processPayment', name: 'app_processPayment')]
    public function processPayment(Request $request, ProductQuantitiesRepository $productQuantitiesRepository, UserInterface $user, OrderR $orderRepo, PPR $purchasedProductRepo, CreatedPerfumeRepository $createdPerfumeRepo, ProductRepository $productRepo): Response
    {

        /*foreach($this->session->get('cart') as $product) {
            if ($createdPerfume['entity']->getProducts()->count()==0) {
                $total += $product['entity']->getSamplingPrice();
            }
        }*/

        $order = json_decode($request->get('order'), true);

        $paypalId = $order['id'];
        $amount = $order['purchase_units'][0]['amount']['value'];
        $status = $order['status'];

        if (/*$total == $amount &&*/ $status == 'COMPLETED') {
            $order = new Order;
            $order->setUser($this->getUser());
            $order->setPaypalId($paypalId);
            $order->setTotal($this->session->get('total'));
            $order->setCreatedAt(new DatetimeImmutable);
            $orderRepo->save($order, true);
            $products = $productRepo->findAll();

            foreach($this->session->get('cart') as $perfume) {

                $newProduct = $createdPerfumeRepo->findOneBy(['id' => $perfume['entity']->getId()]);
                $productQuantities = $productQuantitiesRepository->findOneBy(['createdPerfume'=> $newProduct, 'user' => $user]);

                foreach($newProduct->getProducts() as $product) {
                    foreach($products as $keyBis => $productBis) {
                        if($product == $productBis) {
                            $selected_key = $keyBis;
                        } 
                    } 
                    $purchased = new PurchasedProduct;
                    $purchased->setUnitPrice($product->getPrice());
                    $purchased->setQuantity($productQuantities->getQuantities()[$selected_key]);
                    $purchased->setCommande($order);
                    $purchased->setProduct($product);
                    $purchased->setCreatedPerfume($newProduct);
                    $purchasedProductRepo->save($purchased, true);
                }
                // Attention, ce qui suit est degeu mais bon sinon ca marche pas
                // Je récupère le produit grâce à l'id que j'ai dans ma session (dans l'entitée)
                // Aucune idée de pourquoi l'entitée de la session ne fonctionne pas
            }
            $this->session->set('cart', []);
            
            return new Response(true);
        }

        throw new HttpException(500, 'c\'est cassé');
    }

    #[Route('/merci', name: 'cart.thanks')]
    public function merci(Request $request): Response
    {
        return $this->render('cart/thanks.html.twig');
    }

}
