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
        return $this->validators[$type]->isValid($value);
    }

    public function getValidationFailureMessage($type, $value)
    {
        return $this->validators[$type]->getValidationFailureMessage($value);
    }
}