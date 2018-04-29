<?php

namespace phmLabs\FormValidatorBundle\Validator\Rules;

use phmLabs\FormValidatorBundle\Validator\Validator;

class NotEmpty implements Validator
{
    public function getValidationFailureMessage($value, $parameters = [])
    {
        return "The given value must not be empty.";
    }

    public function isValid($value, $parameters = [])
    {
        return strlen($value) > 0;
    }
}