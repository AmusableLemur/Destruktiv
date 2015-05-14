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
     * @Route("/vault/{level}", name="vault_level", requirements={
     *     "level": "\d+"
     * })
     * @Template()
     */
    public function levelAction($level)
    {
        $em = $this->getDoctrine()->getManager();
        $level = $em->getRepository('DestruktivGameBundle:VaultLevel')->findOneByLevel($level);

        return [
            "page" => "games",
            "level" => $level
        ];
    }

    /**
     * @Route("/vault/admin", name="vault_admin")
     * @Template()
     */
    public function adminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $level = new VaultLevel();

        if ($request->get("edit") !== null) {
            $level = $em->getRepository('DestruktivGameBundle:VaultLevel')->findOneById($request->get("edit"));
        }

        $query = $em->createQuery('SELECT v FROM DestruktivGameBundle:VaultLevel v ORDER BY v.level');
        $levels = $query->getResult();
        $form = $this->createAdminForm($level)
            ->add("spara", "submit");

        $form->handleRequest($request);

        if ($form->isValid()) {
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
