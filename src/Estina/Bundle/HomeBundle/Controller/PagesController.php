<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Translation\Translator;

/**
 * Static pages
 */
class PagesController extends Controller
{
    /**
     * About page
     *
     * @Route("/about", name="page_about")
     * @Template()
     */
    public function aboutAction()
    {
        return [];
    }    

    /**
     * Privacy page
     *
     * @Route("/privacy", name="page_privacy")
     * @Template()
     */
    public function privacyAction()
    {
        return [];
    }

    /**
     * Partners
     *
     * @Route("/remejai", name="page_partners")
     * @Template()
     */
    public function partnersAction()
    {
        return [];
    }

    /**
     * FAQ
     *
     * @Route("/faq", name="page_faq")
     * @Template()
     */
    public function faqAction()
    {

        return [];
    }

    /**
     * Kontaktai
     *
     * @Route("/kontaktai", name="page_contacts")
     * @Template()
     */
    public function contactsAction()
    {
        return [];
    }
}
