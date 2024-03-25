<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForgotPasswordController extends AbstractController
{
    #[Route('/mot-de-passe-oublie', name: 'forgot_password')]
    public function forgotPassword(Request $request): Response
    {
        // Gérer la logique de réinitialisation du mot de passe ici, comme l'envoi d'un lien de réinitialisation par e-mail.
        
        // Rendre votre template pour le mot de passe oublié
        return $this->render('forgot_password/forgot_password.html.twig');
    }
}
