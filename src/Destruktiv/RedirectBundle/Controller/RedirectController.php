<?php

namespace Destruktiv\RedirectBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Destruktiv\RedirectBundle\Entity\Redirect;
use Destruktiv\RedirectBundle\Form\RedirectType;

/**
 * Redirect controller.
 *
 * @Route("/redirect")
 */
class RedirectController extends Controller
{
    /**
     * Creates a new Redirect entity.
     *
     * @Route("/", name="redirect_create")
     * @Method("POST")
     * @Template("DestruktivRedirectBundle:Redirect:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity = new Redirect();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            // Change this
            $entity->setLink(md5($entity->getDestination()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('redirect_new', [
                "link" => $entity->getLink()
            ]));
        }

        return array(
            'entity'   => $entity,
            'entities' => $this->getRedirects(),
            'form'     => $form->createView(),
        );
    }

    /**
     * @todo This should make sure that only links a user has created are listed
     */
    private function getRedirects()
    {
        $em = $this->getDoctrine()->getManager();

        return $em->getRepository('DestruktivRedirectBundle:Redirect')->findAll();
    }

    /**
     * Creates a form to create a Redirect entity.
     *
     * @param Redirect $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Redirect $entity)
    {
        $form = $this->createForm(new RedirectType(), $entity, array(
            'action' => $this->generateUrl('redirect_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', [
            'label' => 'Skapa redirect',
            'attr'  => [
                "class" => "btn-default btn-block"
            ]
        ]);

        return $form;
    }

    /**
     * Displays a form to create a new Redirect entity.
     *
     * @Route("/", name="redirect_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Redirect();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity'   => $entity,
            'entities' => $this->getRedirects(),
            'form'     => $form->createView(),
        );
    }

    /**
     * Finds and displays a Redirect entity.
     *
     * @Route("/{link}", name="redirect_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($link)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DestruktivRedirectBundle:Redirect')->findOneByLink($link);

        if (!$entity) {
            throw $this->createNotFoundException('Hittade ingen redirect som matchade länken');
        }

        return $this->redirect($entity->getDestination());

        $deleteForm = $this->createDeleteForm($link);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Redirect entity.
     *
     * @Route("/{id}/edit", name="redirect_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DestruktivRedirectBundle:Redirect')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Redirect entity.');
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
    * Creates a form to edit a Redirect entity.
    *
    * @param Redirect $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Redirect $entity)
    {
        $form = $this->createForm(new RedirectType(), $entity, array(
            'action' => $this->generateUrl('redirect_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Redirect entity.
     *
     * @Route("/{id}", name="redirect_update")
     * @Method("PUT")
     * @Template("DestruktivRedirectBundle:Redirect:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DestruktivRedirectBundle:Redirect')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Redirect entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('redirect_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Redirect entity.
     *
     * @Route("/{id}", name="redirect_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DestruktivRedirectBundle:Redirect')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Redirect entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('redirect'));
    }

    /**
     * Creates a form to delete a Redirect entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('redirect_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
