<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Estina\Bundle\HomeBundle\Entity\Schedule;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\JsonResponse;

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

        if ($talk && (
            $talk->isAccepted()
            || $talk->getUser() == $this->getUser()
            || $security->isGranted('ROLE_ADMIN')
        )) {
            return ['talk' => $talk];
        }

        throw new NotFoundHttpException;
    }

    /**
     *
     * @Route("/timetable/{day}", name="timetable", defaults={"day" = 1}, requirements={"day" = "\d+"})
     * @Template()
     */
    public function timetablePrettyAction($day)
    {
        $days = Schedule::days();

        if (!in_array($day, $days)) {
            throw new NotFoundHttpException;
        }

        return [
            'timetable' => $this->get('home.schedule_service')->generate($day),
            'days' => $days,
        ];
    }

    /**
     * @Route("/timetable/json", name="timetable-json")
     */
    public function timetableJsonAction()
    {
        

        $days = Schedule::days();
        $timetable = $this->get('home.schedule_service')->generateJson();

        $response = [
            'timetable' => $timetable,
        ];

        return new JsonResponse($timetable);

    }
}
