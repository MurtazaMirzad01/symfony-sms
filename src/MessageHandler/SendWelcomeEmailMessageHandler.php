<?php

namespace App\MessageHandler;

use App\Message\SendWelcomeEmailMessage;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class SendWelcomeEmailMessageHandler
{
    public function __construct(
        private readonly MailerInterface $mailer
    ) {
    }

    public function __invoke(
        SendWelcomeEmailMessage $message
    ): void {

        $email = (new Email())
            ->from('noreply@sms.local')
            ->to($message->getEmail())
            ->subject('Welcome')
            ->text('Welcome to Student App');

        $this->mailer->send($email);
    }
}
