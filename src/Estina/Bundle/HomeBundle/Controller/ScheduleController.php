<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $repo = $this->getDoctrine()->getRepository('Estina\Bundle\HomeBundle\Entity\Track');
        $tracks = $repo->findWorkshopTracks();

        return [
            'tracks' => $tracks
        ];
    }

    /**
     * talksAction
     *
     * @Route("/pranesimai", name="talks")
     * @Template()
     */
    public function talksAction()
    {
        $repo = $this->getDoctrine()->getRepository('Estina\Bundle\HomeBundle\Entity\Track');
        $tracks = $repo->findTalkTracks();

        return [
            'tracks' => $tracks
        ];
    }

    /**
     * talkAction
     *
     * @Route("/pranesimai/{id}", name="talk")
     * @Template()
     */
    public function talkAction($id)
    {
        $repo = $this->getDoctrine()->getRepository('EstinaHomeBundle:Talk');
        $talk = $repo->findOneById($id);
        $security = $this->get('security.context');

        if (!$talk
            || (!$talk->isAccepted() && !$security->isGranted('ROLE_ADMIN'))
        ) {
            throw new NotFoundHttpException;
        }

        return ['talk' => $talk];
    }
}
