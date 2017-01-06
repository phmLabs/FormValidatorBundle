<?php

namespace phmLabs\FormValidatorBundle\Validator;

class Domain implements Validator
{
    public function getValidationFailureMessage($value)
    {
        return "The given string is not a valid domain name. Example www.example.com";
    }

    public function isValid($value)
    {
        return strpos($value, '/') === false;
    }
}