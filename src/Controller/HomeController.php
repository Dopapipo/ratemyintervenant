<?php

// src/Controller\HomeController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    #[Route('/home/about', name: 'app_home_about')]
    public function about(): Response
    {
        return $this->render('home/about.html.twig');
    }

    #[Route('/home/services', name: 'app_home_services')]
    public function services(): Response
    {
        return $this->render('home/services.html.twig');
    }


}
