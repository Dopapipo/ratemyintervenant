<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\BlogPostType;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog')]
class BlogController extends AbstractController
{   
    public function __construct(private readonly Security $security)
    {
    }
    #[Route('', name: 'app_blog_index', methods: ['GET'])]
    public function index( Request $request): Response
    {
        $user = $this->security->getUser();
        $professeurs = $user->getClasse()->getIntervenants();
        return $this->render('blog/index.html.twig', [
            'professeurs' => $professeurs,
        ]);
    }

  

}
