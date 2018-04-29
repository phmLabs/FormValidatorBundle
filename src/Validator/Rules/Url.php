<?php

namespace phmLabs\FormValidatorBundle\Validator\Rules;

use GuzzleHttp\Psr7\Uri;
use phmLabs\FormValidatorBundle\Validator\Validator;

class Url implements Validator
{
    private function getDomain(Uri $uri)
    {
        $array = explode(".", $uri->getHost());
        return (array_key_exists(count($array) - 2, $array) ? $array[count($array) - 2] : "") . "." . $array[count($array) - 1];
    }

    public function getValidationFailureMessage($value, $parameters = [])
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            if (array_key_exists('domain', $parameters)) {
                $domain = $parameters['domain'];
            } else {
                $domain = "example.com";
            }

            return "The given string is not a valid url. Example http://www." . $domain . "/main.html";
        }

        if (array_key_exists('domain', $parameters)) {
            $uri = new Uri($value);

            if ($this->getDomain($uri) != $parameters['domain']) {
                return "The given url's domain must be " . $parameters['domain'] . '.';
            }
        }
    }

    public function isValid($value, $parameters = [])
    {
        if (!filter_var($value, FILTER_VALIDATE_URL)) {
            return false;
        }

        if (array_key_exists('domain', $parameters)) {
            $uri = new Uri($value);

            if ($this->getDomain($uri) != $parameters['domain']) {
                return false;
            }
        }

        return true;
    }
}