<?php

namespace phmLabs\FormValidatorBundle\Controller;

use phmLabs\FormValidatorBundle\Validator\Rules\Domain;
use phmLabs\FormValidatorBundle\Validator\Handler;
use phmLabs\FormValidatorBundle\Validator\Rules\NonSpaceEnclosing;
use phmLabs\FormValidatorBundle\Validator\Rules\NotEmpty;
use phmLabs\FormValidatorBundle\Validator\Rules\PathWithQuery;
use phmLabs\FormValidatorBundle\Validator\Rules\Url;
use phmLabs\FormValidatorBundle\Validator\Rules\XPath;
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
        $this->validationHandler->addValidator('domain', new Domain());
        $this->validationHandler->addValidator('url', new Url());
        $this->validationHandler->addValidator('pathwithquery', new PathWithQuery());
        $this->validationHandler->addValidator('nonspaceenclosing', new NonSpaceEnclosing());
        $this->validationHandler->addValidator('notempty', new NotEmpty());
    }

    public function validateAction(Request $request)
    {
        $this->initValidationHandler();

        $type = $request->get('type');
        $value = $request->get('value');
        $element = $request->get('element');


        $parameters = json_decode($request->get('parameters'), true);

        if (!$element) {
            $element = "not set";
        }

        if ($this->validationHandler->isValid($type, $value, $parameters)) {

            return new JsonResponse(['message' => 'The given value is valid (' . $type . ')', 'isValid' => true, 'element' => $element]);

        } else {
            $repairedValue = $this->validationHandler->getRepairedValue($type, $value, $parameters);

            $response = [
                'message' => $this->validationHandler->getValidationFailureMessage($type, $value, $parameters),
                'isValid' => false,
                'element' => $element
            ];

            if ($repairedValue) {
                $response['repairedValue'] = $repairedValue;
            }

            return new JsonResponse($response);
        }
    }
}
