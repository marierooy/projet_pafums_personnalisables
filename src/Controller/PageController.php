<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(): Response
    {
        return $this->render('page/accueil.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    #[Route('/boutiques/ephemeres', name: 'app_boutiques_ephemeres')]
    public function boutiquesEphemeres(): Response
    {
        return $this->render('page/boutiques_ephemeres.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
