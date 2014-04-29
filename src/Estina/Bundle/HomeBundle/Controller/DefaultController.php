<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Estina\Bundle\HomeBundle\Form\TalkType;
use Estina\Bundle\HomeBundle\Event\TalkEvent;
use Estina\Bundle\HomeBundle\EventListener\TalkListener;
use Estina\Bundle\HomeBundle\TalkEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * DefaultController 
 */
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
     * @Route("/register", name="register")
     * @Template()
     */
    public function registerAction()
    {
        $form = $this->createForm(new TalkType, null, [
            'action' => $this->generateUrl('register')
        ]);

        $request = $this->get('request');

        if ('POST' === $request->getMethod()) {
            $form->bind($request);

            if ($form->isValid()) {
                $talk = $form->getData();
                $em = $this->getDoctrine()->getManager();
                $em->persist($talk);
                $em->flush();

                $event = new TalkEvent($talk);
                $this->get('debug.event_dispatcher')
                    ->dispatch(TalkEvents::CREATE, $event);
            }
        }

        return [
            'form' => $form->createView()
        ];
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

    /**
     * Partners block 
     * 
     * @Template()
     */
    public function partnersAction()
    {
        return [];
    }

    /**
     * FAQ block 
     * 
     * @Template()
     */
    public function faqAction()
    {
        return [];
    }
}
