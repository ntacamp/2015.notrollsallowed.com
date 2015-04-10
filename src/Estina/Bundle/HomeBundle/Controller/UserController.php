<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Estina\Bundle\HomeBundle\Entity\User;
use Estina\Bundle\HomeBundle\Form\LoginType;
use Estina\Bundle\HomeBundle\Form\RegistrationType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * UserController
 */
class UserController extends Controller
{
    /**
     * @Route("/login", name="login_route")
     * @Template()
     */
    public function loginAction()
    {
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        $loginForm = $this->createForm(new LoginType());

        return [
                'loginForm' => $loginForm->createView(),
                'last_username' => $lastUsername,
                'error' => $error,
            ];
    }

    /**
     * @Route("/login_check", name="login_check")
     */
    public function loginCheckAction()
    {
    }

    /**
     * @Route("/registracija", name="user_registration")
     * @Template()
     */
    public function registrationAction(Request $request)
    {
        $entity = new User();
        $form = $this->createForm(new RegistrationType(), $entity);
        $service = $this->container->get('home.user_service');

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            if($form->isValid()) {
                $service->createUser($entity);
                return new RedirectResponse($this->generateUrl('user_registration_finish'));
            }
        }

        return ['registrationFrom' => $form->createView()];
    }

    /**
     * @Route("/slaptazodzio-priminimas", name="user_password_reset")
     * @Template()
     *
     * @param Request $request
     */
    public function passwordResetAction(Request $request)
    {
        $service = $this->container->get('home.user_service');
        $service->resetPassword('dariusleskauskas@gmail.com');
    }

    /**
     * @Route("/registracija-baigta", name="user_registration_finish")
     * @Template()
     */
    public function registrationFinishAction()
    {
        return [];
    }

    /**
     * @Route("/profilis", name="user_profile")
     * @Template()
     */
    public function profileAction()
    {
        return [];
    }

}
