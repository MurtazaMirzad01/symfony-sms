<?php

namespace App\EventSubscriber;

use App\Event\StudentDeletedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class StudentDeletedFlashSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly RequestStack $requestStack
    )
    {

    }
    public function onStudentDeletedEvent(StudentDeletedEvent $event): void
    {
        $this->requestStack
            ->getSession()
            ->getFlashBag()
            ->add(
                'danger',
                sprintf(
                '%s deleted.',
                $event->getStudent()->getName()
                )
            );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            StudentDeletedEvent::class => 'onStudentDeletedEvent',
        ];
    }
}
