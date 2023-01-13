<?php

namespace App\Controller;

use App\Entity\Order;
use DatetimeImmutable;
use App\Entity\Product;
use Psr\Log\LoggerInterface;
use App\Entity\CreatedPerfume;
use App\Entity\PurchasedProduct;
use App\Repository\ProductRepository;
use App\Repository\OrderRepository as OrderR;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RequestStack;
use App\Repository\PurchasedProductRepository as PPR;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CartController extends AbstractController
{
    private $session;

    public function __construct(RequestStack $requestStack) {
        $this->session = $requestStack->getSession();
    }
    
    #[Route('/cart', name: 'app_cart')]
    public function index(): Response
    {
        $total = 0;

        if (!is_null($this->session->get('cart'))) {
            foreach($this->session->get('cart') as $createdPerfume) {
                if ($createdPerfume['entity']->getProducts()->count()==0) {
                    $total += $createdPerfume['entity']->getSamplingPrice();
                }
            }
        }

        return $this->render('cart/index.html.twig', [
           'total' => $total
        ]);
    }


    #[Route('/addToCart/{id}', name: 'app_add_to_cart')]
    public function addToCart(Request $request, CreatedPerfume $createdPerfume): Response
    {
        $this->session->set('cart', []);
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

    #[Route('/processPayment', name: 'app_processPayment')]
    public function processPayment(Request $request, OrderR $orderRepo, PPR $purchasedProductRepo, LoggerInterface $logger, ProductRepository $productRepo): Response
    {
        $total = 0;

        foreach($this->session->get('cart') as $product) {
            $total += $product['entity']->getSamplingPrice();
        }

        $order = json_decode($request->get('order'), true);

        $paypalId = $order['id'];
        $amount = $order['purchase_units'][0]['amount']['value'];
        $status = $order['status'];

        if ($total == $amount && $status == 'COMPLETED') {
            $order = new Order;
            $order->setUser($this->getUser());
            $order->setPaypalId($paypalId);
            $order->setTotal($total);
            $order->setCreatedAt(new DatetimeImmutable);
            $orderRepo->save($order, true);

            foreach($this->session->get('cart') as $product) {
                $purchased = new PurchasedProduct;
                $purchased->setCommande($order);
                // Attention, ce qui suit est degeu mais bon sinon ca marche pas
                // Je récupère le produit grâce à l'id que j'ai dans ma session (dans l'entitée)
                // Aucune idée de pourquoi l'entitée de la session ne fonctionne pas
                $newProduct = $productRepo->findOneBy(['id' => $product['entity']->getId()]);
                $purchased->setProduct($newProduct);
                $purchased->setQuantity($product['quantity']);
                $purchased->setUnitPrice($product['entity']->getPrice());
                $purchasedProductRepo->save($purchased, true);
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
