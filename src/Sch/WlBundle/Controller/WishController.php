<?php

namespace Sch\WlBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sch\WlBundle\Entity\Wish;
use Sch\WlBundle\Form\WishType;

/**
 * Wish controller.
 *
 * @Route("/wish")
 */
class WishController extends Controller
{

    /**
     * Lists all Wish entities.
     *
     * @Route("/")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $usr = $this->get('security.context')->getToken()->getUser();

        $entities = $em->getRepository('SchWlBundle:Wish')->findAllForUser($usr);

        $deleteForms = array_map(function($wish){
            return $this->createDeleteForm($wish->getId())->createView();
        }, $entities);

        return array(
            'entities' => $entities,
            'delete_forms' => $deleteForms
        );
    }

    /**
     * Creates a new Wish entity.
     *
     * @Route("/")
     * @Method("POST")
     * @Template("SchWlBundle:Wish:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $usr = $this->get('security.context')->getToken()->getUser();

        $entity = new Wish();
        $entity->setUser($usr);

        $form = $this->createForm(new WishType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Félicitations ! Votre voeu a été ajouté.'
            );

            return $this->redirect($this->generateUrl('sch_wl_wish_index'));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Wish entity.
     *
     * @Route("/new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $user = $this->get('security.context')->getToken()->getUser();

        /** @var Wish $entity */
        $entity = new Wish();
        $entity->setUser($user);

        $form   = $this->createForm(new WishType(), $entity);

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Finds and displays a Wish entity.
     *
     * @Route("/{id}")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SchWlBundle:Wish')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wish entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Wish entity.
     *
     * @Route("/{id}/edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SchWlBundle:Wish')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wish entity.');
        }

        $editForm = $this->createForm(new WishType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity' => $entity,
            'form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Wish entity.
     *
     * @Route("/{id}/edit")
     * @Method("PUT")
     * @Template("SchWlBundle:Wish:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SchWlBundle:Wish')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Wish entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new WishType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Voeu modifié.'
            );

            return $this->redirect($this->generateUrl('sch_wl_wish_index'));
        }

        return array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Wish entity.
     *
     * @Route("/{id}")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SchWlBundle:Wish')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Wish entity.');
            }

            $em->remove($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                'Ce voeu a été supprimé.'
            );
        }

        return $this->redirect($this->generateUrl('sch_wl_wish_index'));
    }

    /**
     * Creates a form to delete a Wish entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }
}
