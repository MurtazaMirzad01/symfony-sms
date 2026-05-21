<?php

namespace App\EventListener;

use App\Entity\Student;
use App\Event\StudentCreatedEvent;
use App\Event\StudentDeletedEvent;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;


class StudentEntityListener
{
    public function __construct(
        private readonly EventDispatcherInterface $eventDispatcher)
    {

    }

    public function postPersist(
        Student $student
    ): void
    {
        $this->eventDispatcher
            ->dispatch(
                new StudentCreatedEvent($student),
            );
    }
    public function postRemove(
        Student $student
    )
    {
        $this->eventDispatcher
            ->dispatch(
                new StudentDeletedEvent($student),
            );
    }
}
