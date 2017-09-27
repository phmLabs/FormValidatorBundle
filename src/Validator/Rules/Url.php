<?php

namespace phmLabs\FormValidatorBundle\Validator\Rules;

use phmLabs\FormValidatorBundle\Validator\Validator;

class Url implements Validator
{
    public function getValidationFailureMessage($value)
    {
        return "The given string is not a valid url. Example http://www.example.com/main.html";
    }

    public function isValid($value)
    {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }
}