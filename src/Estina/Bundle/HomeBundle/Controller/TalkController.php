<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Estina\Bundle\HomeBundle\Entity\Talk;
use Estina\Bundle\HomeBundle\Event\TalkEvent;
use Estina\Bundle\HomeBundle\Form\RegisterTalkType;
use Estina\Bundle\HomeBundle\Form\TalkType;
use Estina\Bundle\HomeBundle\TalkEvents;
use Estina\Bundle\HomeBundle\Event\RegistrationEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;

/**
 * Talk controller.
 *
 * @Route("/t")
 */
class TalkController extends Controller
{
    /**
     * Register talk. 
     * 
     * @Route("/pranesimo-registracija", name="talk_register")
     * @Template()
     */
    public function registerAction(Request $request)
    {
        $entity = new Talk();
        $form   = $this->createRegistrationForm($entity);

        if ('POST' === $request->getMethod()) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $userService = $this->get('home.user_service');
                try {
                    $userService->createUser($entity->getUser());
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($entity);
                    $em->flush();

                    $event = new TalkEvent($entity);
                    $registrationEvent = new RegistrationEvent($entity->getUser());

                    $this->get('event_dispatcher')
                        ->dispatch(TalkEvents::CREATE, $event);

                    $this->get('event_dispatcher')
                        ->dispatch(RegistrationEvent::NAME, $registrationEvent);

                    return $this->redirect(
                        $this->generateUrl('talk_success'));
                } catch (UniqueConstraintViolationException $e) {
                    // @todo add error on email field.
                    $error = new FormError("Toks vartotojas jau egzistuoja");
                    $form->addError($error);
                }
            }
        }

        return array(
            'form' => $form->createView(),
        );
    }

    /**
     * Display info after sucessful registration. 
     * 
     * @Route("/registracija-sekminga", name="talk_success")
     * @Template()
     */
    public function successAction()
    {
        return [];
    }
    
    /**
     * @param Talk $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createRegistrationForm(Talk $entity)
    {
        $form = $this->createForm(new RegisterTalkType(), $entity, [
            'action' => $this->generateUrl('talk_register'),
            'method' => 'POST',
        ]);

        $form->add('submit', 'submit', array('label' => 'Registruotis'));

        return $form;
    }

    /**
     * Lists all Talk entities.
     *
     * @Route("/", name="talk_list")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('EstinaHomeBundle:Talk')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * List personal talks.
     *
     * @Template()
     */
    public function personalTalksAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $repo = $this->getDoctrine()->getRepository('Estina\Bundle\HomeBundle\Entity\Talk');
        $talks = $repo->findByUser($user);

        return ['talks' => $talks];
    }

    /**
     * Creates a new Talk entity.
     *
     * @Route("/", name="talk_create")
     * @Method("POST")
     * @Template("EstinaHomeBundle:Talk:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Talk();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $user = $this->get('security.context')->getToken()->getUser();
            $entity->setUser($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->set(
                'success',
                'Jūsų pranešimas buvo sėkmingai užregistruotas!'
            );
            return $this->redirect($this->generateUrl('talk_new'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Talk entity.
     *
     * @param Talk $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Talk $entity)
    {
        $form = $this->createForm(new TalkType(), $entity, array(
            'action' => $this->generateUrl('talk_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Registruotis'));

        return $form;
    }

    /**
     * Displays a form to create a new Talk entity.
     *
     * @Route("/new", name="talk_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Talk();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }


    /**
     * Displays a form to edit an existing Talk entity.
     *
     * @Route("/{id}/edit", name="talk_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        //@todo add file upload
        //@todo allow user mark if he'll not be able to participate.
        //@todo validate if there are enough place for new talks on selected track.
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EstinaHomeBundle:Talk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Talk entity.');
        }

        if (!$this->isAllowedUpdate($entity)) {
            throw $this->createAccessDeniedException();
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Check if user is allowed edit entity.
     *
     * @param Talk $entity
     *
     * @return bool
     */
    private function isAllowedUpdate(Talk $entity)
    {
        $security = $this->get('security.context');
        $user = $security->getToken()->getUser();
        return ($entity->getUser() == $user || $security->isGranted('ROLE_ADMIN'));
    }

    /**
    * Creates a form to edit a Talk entity.
    *
    * @param Talk $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Talk $entity)
    {
        $form = $this->createForm(new TalkType(TalkType::NO_USER_FIELDS), $entity, array(
            'action' => $this->generateUrl('talk_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Atnaujinti'));

        return $form;
    }
    /**
     * Edits an existing Talk entity.
     *
     * @Route("/{id}", name="talk_update")
     * @Method("PUT")
     * @Template("EstinaHomeBundle:Talk:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EstinaHomeBundle:Talk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Talk entity.');
        }

        if (!$this->isAllowedUpdate($entity)) {
            throw $this->createAccessDeniedException();
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->set(
                'success',
                'Jūsų pranešimas buvo sėkmingai atnaujintas!'
            );

            return $this->redirect($this->generateUrl('user_profile'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    
    /**
     * Deletes a Talk entity.
     *
     * @Route("/{id}", name="talk_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EstinaHomeBundle:Talk')->find($id);
            
            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Talk entity.');
            }

            if (!$this->isAllowedUpdate($entity)) {
                throw $this->createAccessDeniedException();
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('talk', ['id' => $id]));
    }

    /**
     * Creates a form to delete a Talk entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('talk_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    /**
     * @Route("/cancel/{id}", name="talk_cancel")
     * @Method("GET")
     * @Template()
     */
    public function cancelAction($id)
    {
        $form = $this->createCancelForm($id);

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EstinaHomeBundle:Talk')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Talk entity.');
        }

        if (!$this->isAllowedUpdate($entity)) {
            throw $this->createAccessDeniedException();
        }

        return array(
            'entity'      => $entity,
            'form'  => $form->createView(),
        );
    }

    /**
     * @Route("/cancel/{id}/confirm", name="talk_cancel_confirm")
     * @Method("PUT")
     */
    public function cancelConfirmAction($id, Request $request)
    {
        $form = $this->createCancelForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('EstinaHomeBundle:Talk')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Talk entity.');
            }

            if (!$this->isAllowedUpdate($entity)) {
                throw $this->createAccessDeniedException();
            }

            $entity->cancel();
            $em->flush();

            $this->get('session')->getFlashBag()->set(
                'success',
                'Jūsų pranešimas atšauktas. Tikimės, kad dar persigalvosit ;-)'
            );
        }

        return $this->redirect($this->generateUrl('talk', ['id' => $id]));
    }

    /**
     * Creates a form to delete a Talk entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCancelForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('talk_cancel_confirm', array('id' => $id)))
            ->setMethod('PUT')
            ->add('submit', 'submit', array('label' => 'Atšaukti pranešimą'))
            ->getForm()
        ;
    }
}
