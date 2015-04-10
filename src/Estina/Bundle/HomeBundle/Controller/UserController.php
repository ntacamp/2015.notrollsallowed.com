<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

        return [
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
     * @Route("/profilis", name="user_profile")
     * @Template()
     */
    public function profileAction()
    {
        return [];
    }

}
