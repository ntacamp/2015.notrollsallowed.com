<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Static pages 
 */
class PagesController extends Controller
{
    /**
     * About page 
     * 
     * @Route("/apie", name="about")
     * @Template()
     */
    public function aboutAction()
    {
        return [];
    }

    /**
     * Partners 
     * 
     * @Route("/remejai", name="partners")
     * @Template()
     */
    public function partnersAction()
    {
        return [];
    }

    /**
     * FAQ 
     * 
     * @Route("/duk", name="faq")
     * @Template()
     */
    public function faqAction()
    {
        return [];
    }

    /**
     * Kontaktai
     * 
     * @Route("/kontaktai", name="contacts")
     * @Template()
     */
    public function contactsAction()
    {
        return [];
    }
}
