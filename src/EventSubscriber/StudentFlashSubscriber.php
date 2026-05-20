<?php

namespace App\EventSubscriber;

use App\Event\StudentCreatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RequestStack;


class StudentFlashSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {

    }
    public function onStudentCreatedEvent(StudentCreatedEvent $event): void
    {
        $this->requestStack
            ->getSession()
            ->getFlashBag()
            ->add(
                'success',
                sprintf(
                    '%s Creted Successfully.',
                    $event->getStudent()->getName()
                )
            );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            StudentCreatedEvent::class => 'onStudentCreatedEvent',
        ];
    }
}
