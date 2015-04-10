<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Schedule, workshops and talks.
 */
class ScheduleController extends Controller
{
    /**
     * workshopsAction 
     * 
     * @Route("/dirbtuves", name="workshops")
     * @Template()
     */
    public function workshopsAction()
    {
        return [];
    }

    /**
     * talksAction 
     * 
     * @Route("/pranesimai", name="talks")
     * @Template()
     */
    public function talksAction()
    {
        return [];
    }
}
