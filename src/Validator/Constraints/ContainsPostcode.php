<?php
namespace App\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsPostcode extends Constraint
{
    public $message = '"{{ string }}" is not a valid postcode';
}