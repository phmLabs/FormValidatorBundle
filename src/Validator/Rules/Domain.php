<?php

namespace phmLabs\FormValidatorBundle\Validator\Rules;

use GuzzleHttp\Psr7\Uri;
use phmLabs\FormValidatorBundle\Validator\RepairAwareValidator;

class Domain implements RepairAwareValidator
{
    public function getValidationFailureMessage($value, $parameters = [])
    {
        if (strpos($value, 'http') === 0) {
            $url = $value;
        } else {
            $url = 'https://' . $value;
        }

        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $urlParts = parse_url($url);
            return "The given string is not a valid domain name. Example " . $urlParts['host'];
        } else {
            return "The given string is not a valid domain name. Example www.example.com";
        }
    }

    public function isValid($value, $parameters = [])
    {
        if (strpos($value, '/') !== false) {
            return false;
        }

        return filter_var('http://' . $value, FILTER_VALIDATE_URL) !== false;
    }

    public function getRepairedValue($value, $parameters = [])
    {
        try {
            if (strpos($value, 'http') === 0) {
                $url = $value;
            } else {
                $url = 'https://' . $value;
            }

            $url = new Uri($url);
            return $url->getHost();
        } catch (\Exception $e) {
            return false;
        }
    }
}
