<?php

namespace App\EventSubscriber;

use App\Event\StudentCreatedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StudentCreatedSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            StudentCreatedEvent::class =>
                'onStudentCreated'
        ];
    }

    public function onStudentCreated(
        StudentCreatedEvent $event
    ): void {

        $student =
            $event
                ->getStudent();

        $this->logger->info(
            sprintf(
                'Student created: %s',
                $student->getName()
            )
        );
    }

}
