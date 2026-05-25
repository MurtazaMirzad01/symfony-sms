<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
class MailerService
{
    public function __construct(
        private readonly MailerInterface $mailer
    )
    {
    }
    public function sendWelcome(
        string $email,
    ) : void
    {
        $message = new TemplatedEmail()
            ->from(
                'noreply@sms.local'
            ) ->to($email)
            ->subject('Welcome to SMS')
            ->htmlTemplate('emails/welcome.html.twig')
            ->context([
                'userEmail' => $email,
            ]);
        $this->mailer->send($message);
    }

    public function sendReset(
        string $email,
        string $token,
    ): void
    {
        $message = new TemplatedEmail()
            ->from('noreply@sms.local')
            ->to($email)
            ->subject('Password reset')
            ->htmlTemplate('emails/reset.html.twig')
            ->context([
                'token' => $token,
            ]);

        $this->mailer->send($message);
    }
}
