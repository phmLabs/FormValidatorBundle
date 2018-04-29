<?php

namespace phmLabs\FormValidatorBundle\Validator\Rules;

use phmLabs\FormValidatorBundle\Validator\Validator;

class XPath implements Validator
{
    public function getValidationFailureMessage($value, $parameters = [])
    {
        return "The given value is not a valid xpath query.";
    }

    public function isValid($value, $parameters = [])
    {
        $xpath = new \DOMXPath(new \DOMDocument());
        $query_id = @$xpath->query($value);

        if (!($query_id)) {
            return false;
        } else {
            return true;
        }
    }
}