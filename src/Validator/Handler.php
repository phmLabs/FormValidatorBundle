<?php

namespace phmLabs\FormValidatorBundle\Validator;

class Handler
{
    /**
     * @var Validator[];
     */
    private $validators = array();

    public function addValidator($alias, Validator $validator)
    {
        $this->validators[$alias] = $validator;
    }

    public function isValid($type, $value, $parameters = [])
    {
        if (array_key_exists($type, $this->validators)) {
            return $this->validators[$type]->isValid($value, $parameters);
        } else {
            throw new \RuntimeException('Unknown validator: ' . $value);
        }
    }

    public function getValidationFailureMessage($type, $value, $parameters = [])
    {
        return $this->validators[$type]->getValidationFailureMessage($value, $parameters);
    }

    public function getRepairedValue($type, $value, $parameters = [])
    {
        $validator = $this->validators[$type];
        if ($validator instanceof RepairAwareValidator) {
            return $validator->getRepairedValue($value, $parameters);
        } else {
            return false;
        }
    }
}