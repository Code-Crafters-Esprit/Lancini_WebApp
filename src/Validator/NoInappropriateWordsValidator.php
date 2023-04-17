<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class NoInappropriateWordsValidator extends ConstraintValidator
{
    private $inappropriateWords = ['badword1', 'badword2', 'badword3'];

    public function validate($value, Constraint $constraint)
    {
        $containsBadWord = false;

        foreach ($this->inappropriateWords as $word) {
            if (stripos($value, $word) !== false) {
                $containsBadWord = true;
                break;
            }
        }

        if ($containsBadWord) {
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }
    }
}
