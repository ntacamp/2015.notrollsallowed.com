<?php
/**
 * Created by PhpStorm.
 * User: andriusjalincas
 * Date: 2019-04-10
 * Time: 15:05
 */

namespace Estina\Bundle\HomeBundle\EventListener;


use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\Translation\Translator;

class CoreListener
{
    private $translator;

    public function __construct(Translator $translator)
    {
        $this->translator = $translator;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (HttpKernelInterface::MASTER_REQUEST !== $event->getRequestType()) {
            return;
        }

    }
}