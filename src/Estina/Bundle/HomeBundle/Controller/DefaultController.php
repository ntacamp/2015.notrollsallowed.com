<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Estina\Bundle\HomeBundle\Form\TalkType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
