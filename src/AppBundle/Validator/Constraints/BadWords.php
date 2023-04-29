<?php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class BadWords extends Constraint
{
    public $message = 'The string "{{ string }}" contains a bad word.';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}