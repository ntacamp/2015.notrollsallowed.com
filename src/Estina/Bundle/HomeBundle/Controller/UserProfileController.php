<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Estina\Bundle\HomeBundle\Entity\User;
use Estina\Bundle\HomeBundle\EventListener\UserListener;
use Estina\Bundle\HomeBundle\Event\PasswordResetEvent;
use Estina\Bundle\HomeBundle\Event\RegistrationEvent;
use Estina\Bundle\HomeBundle\Form\LoginType;
use Estina\Bundle\HomeBundle\Form\PasswordResetType;
use Estina\Bundle\HomeBundle\Form\RegistrationType;
use Estina\Bundle\HomeBundle\Form\UserType;
use Estina\Bundle\HomeBundle\UserEvents;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * UserProfileController
 * @Route("/profilis")
 */
class UserProfileController extends Controller
{
    /**
     * @Route("/", name="user_profile")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * Displays a form to edit user
     *
     * @Route("/redagavimas", name="user_profile_edit")
     * @Security("has_role('ROLE_USER')")
     * @Method("GET")
     * @Template()
     */
    public function editAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EstinaHomeBundle:User')->find($this->getUser());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(UserType::ADD_ADDITIONAL_FIELDS), $entity, array(
            'action' => $this->generateUrl('user_profile_update'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Atnaujinti'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     * @Route("/atnaujinti", name="user_profile_update")
     * @Method("PUT")
     * @Template("EstinaHomeBundle:UserProfile:edit.html.twig")
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EstinaHomeBundle:User')->find($this->getUser());

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->set(
                'success',
                'Jūsų profilis buvo sėkmingai atnaujintas!'
            );

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }
}
