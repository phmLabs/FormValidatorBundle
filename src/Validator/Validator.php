<?php


namespace phmLabs\FormValidatorBundle\Validator;

interface Validator
{
    public function getValidationFailureMessage($value, $parameters = []);

    public function isValid($value, $parameters = []);
}
