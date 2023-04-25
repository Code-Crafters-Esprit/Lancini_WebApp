<?php

namespace App\Validator;

use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EventParticipantCountValidator extends ConstraintValidator
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function validate($value, Constraint $constraint)
    {
        /* $value will be an instance of the Evenement entity */
        $participantCount = $this->entityManager->getRepository('App:Participants')->countParticipantsForEvent($value);

        if ($participantCount >= 5) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
