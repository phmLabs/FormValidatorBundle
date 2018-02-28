<?php


namespace phmLabs\FormValidatorBundle\Validator;

interface RepairAwareValidator extends Validator
{
    public function getRepairedValue($value);
}