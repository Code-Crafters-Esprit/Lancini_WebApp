<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class NoInappropriateWords extends Constraint
{
    public $message = 'Please respect our ethics and use friendly language';
}
