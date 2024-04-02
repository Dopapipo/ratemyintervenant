<?php
namespace App\EventSubscriber;

use App\Entity\User;
use App\Exceptions\AccountNotVerifiedException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Event\LoginFailureEvent;

class CheckVerifiedUserSubscriber implements EventSubscriberInterface
{

    public function __construct(private readonly \Symfony\Component\Routing\RouterInterface  $router)
    {
    }
    public static function getSubscribedEvents()
    {
        return [
            CheckPassportEvent::class => ['onCheckPassport', -10],
            LoginFailureEvent::class => ['onLoginFailure'],
        ];
    }
    public function onCheckPassport(CheckPassportEvent $event)
    {
        $passport = $event->getPassport();
        $user = $passport->getUser();
        if (!$user instanceof User) {
            throw new \Exception('Unexpected user type');
        }
        if (!$user->isVerified()) {
            throw new AccountNotVerifiedException();
        }
    }
    public function onLoginFailure(LoginFailureEvent $event)
    {
        if (!$event->getException() instanceof AccountNotVerifiedException) {
            return;
        }
        $response = new RedirectResponse(
            $this->router->generate('app_request_verify_email')
        );
        $event->getRequest()->getSession()->getFlashBag()->add('warning', 'Votre compte n\'est pas encore vérifié. Veuillez vérifier votre boîte de réception pour le lien de vérification.');
        $event->setResponse($response);

    }
}