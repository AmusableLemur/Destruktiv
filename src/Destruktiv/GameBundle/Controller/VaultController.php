<?php

namespace Destruktiv\GameBundle\Controller;

use Destruktiv\GameBundle\Entity\VaultLevel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        return [
            "page" => "games"
        ];
    }

    /**
     * @Route("/vault/admin", name="vault_admin")
     * @Template()
     */
    public function adminAction()
    {
        $levels = [];

        return [
            "page" => "games",
            "levels" => $levels
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
     * @Route("/vault/admin/new", name="vault_new")
     * @Template()
     */
    public function createAction()
    {
    }

    /**
     * @Route("/vault/admin/{id}/delete", name="vault_delete")
     */
    public function deleteAction()
    {
    }

    private function getAdminForm(VaultLevel $level) {
        return $this->createFormBuilder($level)
            ->add("level")
            ->add("hint")
            ->add("password")
            ->getForm();
    }
}
