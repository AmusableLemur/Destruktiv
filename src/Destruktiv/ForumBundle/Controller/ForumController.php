<?php

namespace Destruktiv\ForumBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Destruktiv\ForumBundle\Entity\Thread;
use Destruktiv\ForumBundle\Form\ThreadType;

/**
 * Forum controller.
 *
 * @Route("/forum")
 */
class ForumController extends Controller
{

    /**
     * Lists all threads.
     *
     * @Route("/", name="forum")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('DestruktivForumBundle:Thread')->findAll();

        $entity = new Thread();

        return array(
            'entities' => $entities,
            'form'     => $this->createCreateForm($entity)->createView()
        );
    }

    /**
     * Creates a new Thread entity.
     *
     * @Route("/", name="forum_create")
     * @Method("POST")
     * @Template("DestruktivForumBundle:Thread:new.html.twig")
     */
    public function createAction(Request $request)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw $this->createAccessDeniedException();
        }

        $entity = new Thread();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $entity->setAuthor($this->getUser());
            $entity->setDateCreated(new \DateTime("now"));
            $entity->setDateUpdated(new \DateTime("now"));

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('forum_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Creates a form to create a Thread entity.
     *
     * @param Thread $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Thread $entity)
    {
        $form = $this->createForm(new ThreadType(), $entity, array(
            'action' => $this->generateUrl('forum_create'),
            'method' => 'POST',
        ));

        $form
            ->add("content", "textarea", [
                "label" => false,
                "required" => false,
                "attr" => [
                    "placeholder" => "Innehåll"
                ]
            ])
            ->add('submit', 'submit', [
                'label' => 'Skapa tråd',
                "attr" => [
                    "class" => "btn-primary"
                ]
            ])
        ;

        return $form;
    }

    /**
     * Displays a form to create a new Thread entity.
     *
     * @Route("/new", name="forum_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Thread();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Thread entity.
     *
     * @Route("/{id}", name="forum_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DestruktivForumBundle:Thread')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Thread entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Thread entity.
     *
     * @Route("/{id}/edit", name="forum_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DestruktivForumBundle:Thread')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Thread entity.');
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
    * Creates a form to edit a Thread entity.
    *
    * @param Thread $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Thread $entity)
    {
        $form = $this->createForm(new ThreadType(), $entity, array(
            'action' => $this->generateUrl('forum_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Thread entity.
     *
     * @Route("/{id}", name="forum_update")
     * @Method("PUT")
     * @Template("DestruktivForumBundle:Thread:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('DestruktivForumBundle:Thread')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Thread entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('forum_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Thread entity.
     *
     * @Route("/{id}", name="forum_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        if (!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('DestruktivForumBundle:Thread')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Thread entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('forum'));
    }

    /**
     * Creates a form to delete a Thread entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('forum_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
