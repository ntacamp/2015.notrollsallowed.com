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
     * English page
     *
     * @Route("/en", name="page_en")
     * @Template()
     */
    public function enAction()
    {
        return [];
    }

    /**
     * About page
     *
     * @Route("/apie", name="page_about")
     * @Template()
     */
    public function aboutAction()
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
     * @Route("/duk", name="page_faq")
     * @Template()
     */
    public function faqAction()
    {
        $repo = $this->getDoctrine()->getRepository(
            'Estina\Bundle\HomeBundle\Entity\Track');
        $tracks = $repo->findTracks();

        return [
            'tracks' => $tracks
        ];
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
