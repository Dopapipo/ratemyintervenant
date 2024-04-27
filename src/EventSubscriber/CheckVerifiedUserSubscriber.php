<?php
namespace App\EventSubscriber;

use App\Entity\User;
use App\Exceptions\AccountBannedException;
use App\Exceptions\AccountNotVerifiedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

//Banned users are auto logged out on their next request thanks to how providers work
readonly class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{

    public function __construct(private \Symfony\Component\Routing\RouterInterface $router)
    {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10],
            LoginFailureEvent::class => ['onLoginFailure'],
        ];
    }
    public function onCheckPassport(CheckPassportEvent $event): void
    {
        $passport = $event->getPassport();
        $user = $passport->getUser();
        if (!$user instanceof User) {
            throw new \Exception('Unexpected user type');
        }
        if (!$user->isVerified()) {
            throw new AccountNotVerifiedException();
        }
        if ($user->isIsBanned()) {
            throw new AccountBannedException();
        }
    }
    public function onLoginFailure(LoginFailureEvent $event): void
    {

        if ($event->getException() instanceof AccountNotVerifiedException ) {

            $response = new RedirectResponse(
                $this->router->generate('app_request_verify_email')
            );
            $event->getRequest()->getSession()->getFlashBag()->add('warning', 'Votre compte n\'est pas encore vérifié. Veuillez vérifier votre boîte de réception pour le lien de vérification.');
            $event->setResponse($response);
        }
        if ($event->getException() instanceof AccountBannedException ) {

            $response = new RedirectResponse(
                $this->router->generate('app_home')
            );
            $event->getRequest()->getSession()->getFlashBag()->add('danger', 'Votre compte a été banni. Connexion refusée');
            $event->setResponse($response);
        }
    }
}