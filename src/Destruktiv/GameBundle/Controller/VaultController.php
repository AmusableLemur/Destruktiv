<?php

namespace Destruktiv\GameBundle\Controller;

use Destruktiv\GameBundle\Entity\VaultLevel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class VaultController extends Controller
{
    /**
     * @Route("/vault", name="vault")
     * @Template()
     */
    public function indexAction()
    {
        // Redirect to appropriate level

        return [
            "page" => "games"
        ];
    }

    /**
     * @Route("/vault/admin", name="vault_admin")
     * @Template()
     */
    public function adminAction(Request $request)
    {
        $levels = [];
        $level = new VaultLevel();
        $form = $this->createAdminForm($level)
            ->add("spara", "submit");

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();

            $em->persist($level);
            $em->flush();

            return $this->redirect(
                $this->generateUrl("vault_admin")
            );
        }

        return [
            "page" => "games",
            "levels" => $levels,
            "form" => $form->createView()
        ];
    }

    /**
     * @Route("/vault/admin/{id}", name="vault_edit")
     * @Template()
     */
    public function editAction()
    {
    }

    /**
     * @Route("/vault/admin/{id}/delete", name="vault_delete")
     */
    public function deleteAction()
    {
    }

    private function createAdminForm(VaultLevel $level) {
        return $this->createFormBuilder($level)
            ->add("level", "integer", [
                "label" => "Nivå"
            ])
            ->add("hint", "textarea", [
                "label" => "Hint"
            ])
            ->add("password", "text", [
                "label" => "Lösenord",
                "required" => false
            ])
            ->getForm();
    }
}
