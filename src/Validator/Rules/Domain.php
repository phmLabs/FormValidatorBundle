<?php

namespace phmLabs\FormValidatorBundle\Validator\Rules;

use phmLabs\FormValidatorBundle\Validator\Validator;

class Domain implements Validator
{
    public function getValidationFailureMessage($value)
    {
        return "The given string is not a valid domain name. Example www.example.com";
    }

    public function isValid($value)
    {
        if (strpos($value, '/') !== false) {
            return false;
        }

        return filter_var('http://' . $value, FILTER_VALIDATE_URL) !== false;
    }
}