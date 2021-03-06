<?php

namespace phmLabs\FormValidatorBundle\Validator\Rules;

use phmLabs\FormValidatorBundle\Validator\Validator;

class NonSpaceEnclosing implements Validator
{
    public function getValidationFailureMessage($value, $parameters = [])
    {
        return "The given value starts or ends with a space.";
    }

    public function isValid($value, $parameters = [])
    {
        if (substr($value, 0, 1) == " " || substr($value, -1) == " ") {
            return false;
        } else {
            return true;
        }
    }
}