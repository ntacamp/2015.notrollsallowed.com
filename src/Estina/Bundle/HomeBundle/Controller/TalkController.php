<?php

namespace Estina\Bundle\HomeBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Estina\Bundle\HomeBundle\Entity\Talk;
use Estina\Bundle\HomeBundle\Form\TalkType;

/**
 * Talk controller.
 *
 * @Route("/t")
 */
class TalkController extends Controller
{

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
        $talks = $repo->findTalksByUser($user);

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

            return $this->redirect($this->generateUrl('user_profile'));
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

        $form->add('submit', 'submit', array('label' => 'Create'));

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
        $form = $this->createForm(new TalkType(), $entity, array(
            'action' => $this->generateUrl('talk_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

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

            return $this->redirect($this->generateUrl('talk_edit', array('id' => $id)));
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

            if (!$this->isAllowedUpdate($entity)) {
                throw $this->createAccessDeniedException();   
            }

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Talk entity.');
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
}
