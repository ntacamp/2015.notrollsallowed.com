<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Estina\Bundle\HomeBundle\Entity\User;
use Estina\Bundle\HomeBundle\Event\PasswordResetEvent;
use Estina\Bundle\HomeBundle\Event\RegistrationEvent;
use Estina\Bundle\HomeBundle\EventListener\UserListener;
use Estina\Bundle\HomeBundle\Form\LoginType;
use Estina\Bundle\HomeBundle\Form\PasswordResetType;
use Estina\Bundle\HomeBundle\Form\RegistrationType;
use Estina\Bundle\HomeBundle\UserEvents;
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
     * @Route("/slaptazodzio-priminimas")
     * @Route("/password", name="user_password_reset")
     * @Template()
     */
    public function passwordResetAction(Request $request)
    {
        $service = $this->container->get('home.user_service');
        $form = $this->createForm(new PasswordResetType());

        if($request->isMethod('POST')) {
            $form->handleRequest($request);
            $user = $service->resetPassword($form->getData()['email']);
            if ($user instanceof User) {
                $event = new PasswordResetEvent($user);
                $this->get('event_dispatcher')
                    ->dispatch(UserEvents::PASSWORD_RESET, $event);
                return $this->render('@EstinaHome/User/passwordResetSuccess.html.twig');
            }

            return $this->render('@EstinaHome/User/passwordResetError.html.twig');
        }

        return ['resetForm' => $form->createView()];
    }
}
