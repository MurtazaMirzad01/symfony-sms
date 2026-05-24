<?php

namespace App\Security\Voter;

use App\Entity\Student;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

final class StudentVoter extends Voter
{
    public const EDIT =
        'STUDENT_EDIT';

    public const DELETE =
        'STUDENT_DELETE';

    public function __construct(
        private readonly Security $security
    ) {
    }

    protected function supports(
        string $attribute,
        mixed $subject
    ): bool {

        return
            $subject instanceof Student

            &&

            in_array(
                $attribute,

                [
                    self::EDIT,
                    self::DELETE
                ]
            );
    }

    protected function voteOnAttribute(
        string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool {

        $user =
            $token
                ->getUser();

        if (
            !$user
                instanceof User
        ) {

            return false;
        }

        return
            in_array(
                'ROLE_ADMIN',

                $user
                    ->getRoles()
            );
    }
}
