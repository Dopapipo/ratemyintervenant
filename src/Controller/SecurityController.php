<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;



class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }



    #[Route(path: "/verify", name: "app_verify_email")]

    public function verifyUserEmail(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // Validate the user id and token query parameters
        if (empty ($_GET['id']) || empty ($_GET['token'])) {
            return $this->redirectToRoute('app_home');
        }

        // Validate the user id and token query parameters
        if (!is_string($_GET['id']) || !is_string($_GET['token'])) {
            return $this->redirectToRoute('app_home');
        }

        $id = $_GET['id'];
        $token = $_GET['token'];

        // Verify the user
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);

        if (!$user) {
            return $this->redirectToRoute('app_home');
        }

        // Check if the user has already been verified
        if ($user->isVerified()) {
            return $this->redirectToRoute('app_home');
        }

        // Validate the token
        if (!$user->verify($token)) {
            return $this->redirectToRoute('app_home');
        }

        // Update the user
        $user->setIsVerified(true);
        $this->getDoctrine()->getManager()->flush();

        // Do anything else you need here, like send an email

        return $this->redirectToRoute('app_home');
    }
}