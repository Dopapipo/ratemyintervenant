<?php

namespace App\Controller;

use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProfileController extends AbstractController
{   private Security $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    #[Route('/profile', name: 'app_profile', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('profile/index.html.twig'
        );
    }
    #[Route('/profile/edit', name: 'app_profile_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EntityManagerInterface $entityManager): Response
    {   $user = $this->security->getUser();
        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            return $this->redirectToRoute('app_profile', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('profile/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]
        );
    }
}
