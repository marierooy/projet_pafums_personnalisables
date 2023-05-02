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

    #[Route('/cgv', name: 'app_cgv')]
    public function cgv(): Response
    {
        return $this->render('page/cgv.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    #[Route('/politique/confidentialite', name: 'app_politique_confidentialité')]
    public function politiqueConfidentialite(): Response
    {
        return $this->render('page/politique_confidentialite.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }

    #[Route('/mentions/legales', name: 'app_mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('page/mentions_legales.html.twig', [
            'controller_name' => 'PageController',
        ]);
    }
}
