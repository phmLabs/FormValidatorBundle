<?php

namespace phmLabs\FormValidatorBundle\Validator;

class XPath implements Validator
{
    public function getValidationFailureMessage($value)
    {
        return "The given value is not a valid xpath query.";
    }

    public function isValid($value)
    {
        $xpath = new \DOMXPath(new \DOMDocument());
        $query_id = @$xpath->query($value);

        if (!($query_id)) {
            return false;
        } else {
            return true;
        }

        return true;
    }
}