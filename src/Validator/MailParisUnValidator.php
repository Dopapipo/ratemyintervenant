<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class MailParisUnValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var MailParisUn $constraint */

        if (null === $value || '' === $value) {
            return;
        }

        if (!preg_match('/[A-z0-9]+@etu\.univ-paris1\.fr/i', $value)){
            $this->context->buildViolation($constraint->message)
                ->addViolation();
        }

    }


}
