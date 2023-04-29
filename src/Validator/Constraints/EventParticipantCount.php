<?php
namespace App\Validator\Constraints;

use App\Validator\EventParticipantCountValidator;
use Symfony\Component\Validator\Constraint;

class EventParticipantCount extends Constraint
{
    public $message = 'This event already has the maximum number of participants.';


    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

   
}
