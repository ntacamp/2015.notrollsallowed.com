<?php

namespace Estina\Bundle\HomeBundle\Twig;

use Symfony\Component\HttpFoundation\RequestStack;

class ControllerActionExtension extends \Twig_Extension
{
    /** @var RequestStack */
    protected $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('getControllerName', [$this, 'getControllerName']),
            new \Twig_SimpleFunction('getActionName', [$this, 'getActionName'])
        ];
    }

    /**
     * Get current controller name
     *
     * @return string
    */
    public function getControllerName()
    {
        $request = $this->requestStack->getCurrentRequest();

        if (null !== $request) {
            $pattern = "#Controller\\\([a-zA-Z]*)Controller#";
            $matches = [];
            preg_match($pattern, $request->get('_controller'), $matches);

            return strtolower($matches[1]);
        }
    }

    /**
     * Get current action name
     *
     * @return string
    */
    public function getActionName()
    {
        $request = $this->requestStack->getCurrentRequest();

        if (null !== $request) {
            $pattern = "#::([a-zA-Z]*)Action#";
            $matches = [];
            preg_match($pattern, $request->get('_controller'), $matches);

            return $matches[1];
        }
    }

    public function getName()
    {
        return 'controller_action_twig_extension';
    }
}