<?php

namespace phmLabs\FormValidatorBundle\Controller;

use phmLabs\FormValidatorBundle\Validator\Handler;
use phmLabs\FormValidatorBundle\Validator\XPath;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @var Handler
     */
    private $validationHandler;

    public function initValidationHandler()
    {
        $this->validationHandler = new Handler();
        $this->validationHandler->addValidator('xpath', new XPath());
    }

    public function validateAction(Request $request)
    {
        $this->initValidationHandler();
        $type = $request->get('type');
        $value = $request->get('value');
        $element = $request->get('element');

        if (!$element) {
            $element = "not set";
        }

        if ($this->validationHandler->isValid($type, $value)) {
            return new JsonResponse(['message' => 'The given value is valid (' . $type . ')', 'isValid' => true, 'element' => $element]);
        } else {
            return new JsonResponse(['message' => $this->validationHandler->getValidationFailureMessage($type, $value), 'isValid' => false, 'element' => $element]);
        }

    }
}
