<?php

namespace App\Security\Voter;

use App\Entity\Feedback;
use App\Entity\Format;
use App\Entity\User;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class OwnerVoter extends Voter
{
    public const ACCESS = 'OWNER_ACCESS';

    protected function supports(string $attribute, $subject): bool
    {
        return $attribute === self::ACCESS && is_object($subject);
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }
        
        // On vérifie dynamiquement que le sujet a un propriétaire
        if ($subject instanceof Feedback) {
            return $subject->getNickName()?->getId() === $user->getId();
        }
        
        // On vérifie dynamiquement que le sujet a un propriétaire
        if (method_exists($subject, 'getCustomer')) {
            return $subject->getCustomer()?->getId() === $user->getId();
        }

        if (method_exists($subject, 'getUser')) {
            return $subject->getUser()?->getId() === $user->getId();
        }

        // Et si c'est directement un User
        if ($subject instanceof User) {
            return $subject->getId() === $user->getId();
        }

        return false;
    }
}
