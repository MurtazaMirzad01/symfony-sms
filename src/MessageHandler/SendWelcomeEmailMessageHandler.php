<?php

namespace App\MessageHandler;

use App\Message\SendWelcomeEmailMessage;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Service\MailerService;

#[AsMessageHandler]
class SendWelcomeEmailMessageHandler
{
    public function __construct(
        private readonly MailerService $mailer
    ) {
    }

    public function __invoke(
        SendWelcomeEmailMessage $message
    ): void {

        $this->mailer->sendWelcome(
            $message->getEmail(),
        );
    }
}
