<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RequestVerifyUserEmailType;
use App\Repository\UserRepository;
use App\Security\EmailVerifier;
use App\Security\UserAuthenticator;
use App\Service\EmailService;
use App\Validator\MailParisUn;
use App\Validator\MailParisUnValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private EmailVerifier $emailVerifier;
    private EmailService $emailService;

    public function __construct(EmailVerifier $emailVerifier, EmailService $emailService)
    {
        $this->emailVerifier = $emailVerifier;
       $this->emailService = $emailService;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, Security $security, EntityManagerInterface $entityManager, MailParisUnValidator $validator): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->addRole('ROLE_USER');
            $validator->validate($user->getEmail(), new MailParisUn());
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the makeadminview
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                ($this->emailService->createMail($user->getEmail(), 'Confirmation email ratemyintervenant', 'confirmation_email.html.twig'))
            );
            // do anything else you need here, like send an email
            $this->addFlash('success', 'Enregistrement réussi. Regardez votre e-mail pour pouvoir vous connecter.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/verify', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator, UserRepository $userRepository): Response
    {
        $id = $request->query->get('id');

        if (null === $id) {
            return $this->redirectToRoute('app_register');
        }

        $user = $userRepository->find($id);

        if (null === $user) {
            return $this->redirectToRoute('app_register');
        }
        if ($user->isVerified()) {
            $this->addFlash('success', 'Votre email a déjà été confirmé. Vous pouvez maintenant vous connecter.');
            return $this->redirectToRoute('app_login');
        }
        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $user);
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Votre email a été confirmé. Vous pouvez maintenant vous connecter.');

        return $this->redirectToRoute('app_login');
    }
    /**
     * requestVerifyUserEmail
     */
    #[Route('/request-verify-email', name: 'app_request_verify_email')]
    public function requestVerifyUserEmail(
        Request $request,
        UserRepository $userRepository
    ): Response {

        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        $form = $this->createForm(RequestVerifyUserEmailType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // generate a signed url and email it to the user
            $user =  $userRepository->findOneByEmail($form->get('email')->getData());

            if ($user) {
                $this->emailVerifier->sendEmailConfirmation(
                    'app_verify_email',
                    $user,
                    ($this->emailService->createMail($user->getEmail(), 'Confirmation email ratemyintervenant', 'confirmation_email.html.twig')));
                // do anything else you need here, like flash message
                $this->addFlash('success', "Un email vous a été envoyé. Veuillez consulter votre boîte de réception pour confirmer votre adresse email");
                return $this->redirectToRoute('app_home');
            } else {
                $this->addFlash('error',  'Email inconnu.');
            }
        }
        return $this->render('registration/request_email.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
