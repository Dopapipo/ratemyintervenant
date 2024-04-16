<?php
namespace App\Service;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class EmailService
{
    private MailerInterface $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function createAndSend(string $to, string $subject, string $templateTwig, array $context = []): void
    {
        $email = $this->createMail($to, $subject, $templateTwig, $context);

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }
    public function send(TemplatedEmail $email): void
    {
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw $e;
        }
    }
    public function createMail(string $to, string $subject, string $templateTwig, array $context = []): TemplatedEmail
    {
        return (new TemplatedEmail())
            ->from(new Address("lisniclucian@gmail.com", "noreply"))
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$templateTwig")
            ->context($context);
    }
}