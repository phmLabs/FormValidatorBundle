<?php

namespace phmLabs\FormValidatorBundle\Validator\Rules;

use GuzzleHttp\Psr7\Uri;
use phmLabs\FormValidatorBundle\Validator\RepairAwareValidator;

class PathWithQuery implements RepairAwareValidator
{
    public function getValidationFailureMessage($value)
    {
        return "The given path is not valid.";
    }

    public function isValid($value)
    {
        if (strpos($value, '://') !== false) {
            return false;
        } else {
            if (substr($value, 0, 1) != '/') {
                return false;
            } else {
                return true;
            }
        }
    }

    public function getRepairedValue($value)
    {
        if (strpos($value, '://') !== false) {
            $url = new Uri($value);

            if ($url->getQuery()) {
                $query = '?' . $url->getQuery();
            } else {
                $query = '';
            }

            return $url->getPath() . $query;
        }

        if (substr($value, 0, 1) != '/') {
            return '/' . $value;
        }

        return false;
    }
}
