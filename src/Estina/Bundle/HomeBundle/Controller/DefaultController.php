<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Estina\Bundle\HomeBundle\Form\TalkType;
use Estina\Bundle\HomeBundle\Event\TalkEvent;
use Estina\Bundle\HomeBundle\EventListener\TalkListener;
use Estina\Bundle\HomeBundle\TalkEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * DefaultController 
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
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
        $repo = $this->getDoctrine()->getRepository('Estina\Bundle\HomeBundle\Entity\Talk');
        $talks = $repo->findActiveTalks();

        return [
            'talks' => $talks
        ];
    }
}
