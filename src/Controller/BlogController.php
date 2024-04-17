<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Entity\Intervenant;
use App\Form\BlogPostType;
use App\Repository\BlogPostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/blog')]
class BlogController extends AbstractController
{   
    public function __construct(private readonly Security $security, private readonly EntityManagerInterface $entityManager)
    {
    }
    #[Route('', name: 'app_blog_index', methods: ['GET'])]
    #[IsGranted("ROLE_USER")]
    public function index( Request $request, TranslatorInterface $translator): Response
    {

        $user = $this->getUser();
        //show every intervenant for admins
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $professeurs = $this->entityManager->getRepository(Intervenant::class)->findAll();
        } else {
            //Previously, you would see intervenants added for your class with no matieres, now you see intervenants that teach your matieres
            $professeurs = $this->entityManager->getRepository(Intervenant::class)->findAllWithMatieresFromUser($user);
        }
        return $this->render('blog/index.html.twig', [
            'professeurs' => $professeurs,
        ]);
    }

  

}
