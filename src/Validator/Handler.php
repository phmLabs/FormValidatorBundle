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

    public function isValid($type, $value)
    {
        if (array_key_exists($type, $this->validators)) {
            return $this->validators[$type]->isValid($value);
        } else {
            throw new \RuntimeException('Unknown validator: ' . $value);
        }
    }

    public function getValidationFailureMessage($type, $value)
    {
        return $this->validators[$type]->getValidationFailureMessage($value);
    }

    public function getRepairedValue($type, $value)
    {
        if ($this->validators[$type] instanceof RepairAwareValidator) {
            return $this->validators[$type]->getRepairedValue($value);
        } else {
            return false;
        }
    }
}