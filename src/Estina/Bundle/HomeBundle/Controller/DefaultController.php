<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * Register user 
     * 
     * @param Request $request 
     *
     * @Route("/register")
     * @Template()
     */
    public function registerAction()
    {
        return [];
    }

    /**
     * Speakers list 
     * 
     * @Route("/pranesejai", name="speakers")
     * @Template()
     */
    public function speakersAction()
    {
        return [];
    }
}
