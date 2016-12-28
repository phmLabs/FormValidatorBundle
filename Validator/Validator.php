<?php


namespace phmLabs\FormValidatorBundle\Validator;

interface Validator
{
    public function getValidationFailureMessage($value);

    public function isValid($value);
}