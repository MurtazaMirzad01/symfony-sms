<?php

namespace App\EventSubscriber;

use App\Event\StudentDeletedEvent;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class StudentDeletedEventSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly LoggerInterface $logger)
    {
    }
    public static function getSubscribedEvents(): array
    {
        return [
            StudentDeletedEvent::class => 'onStudentDeletedEvent',
        ];
    }

    public function onStudentDeletedEvent(StudentDeletedEvent $event): void
    {
        $student = $event->getStudent();

        $this->logger->info('Student deleted', [
            'student_id'   => $student->getId(),
            'student_name' => $student->getName(),
        ]);
    }


}
