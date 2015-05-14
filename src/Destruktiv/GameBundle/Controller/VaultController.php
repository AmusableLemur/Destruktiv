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
    public function indexAction(Request $request)
    {
        $level = $this->getUser()->getVaultLevel();

        if ($level === null) {
            $em = $this->getDoctrine()->getManager();
            $query = $em->createQuery('SELECT v FROM DestruktivGameBundle:VaultLevel v ORDER BY v.level')
                ->setMaxResults(1);
            $level = $query->getOneOrNullResult();
        }

        $form = $this->createLevelForm($level);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $data = $form->getData();

            if (strtolower($level->getPassword()) == strtolower($data["password"])) {
                $query = $em->createQuery(
                        'SELECT v
                        FROM DestruktivGameBundle:VaultLevel v
                        WHERE v.level > :level
                        ORDER BY v.level'
                    )
                    ->setParameter("level", $level->getLevel())
                    ->setMaxResults(1);
                $nextLevel = $query->getOneOrNullResult();

                if ($nextLevel === null) {
                    return [
                        "page" => "games",
                        "level" => null,
                        "form" => $form->createView()
                    ];
                }

                $user = $this->getUser();

                $user->setVaultLevel($nextLevel);
                $this->get("fos_user.user_manager")->updateUser($user);

                return $this->redirect(
                    $this->generateUrl("vault")
                );
            }
        }

        return [
            "page" => "games",
            "level" => $level,
            "form" => $form->createView()
        ];
    }

    private function createLevelForm(VaultLevel $level)
    {
        return $this->createFormBuilder()
            ->add("password", "text", [
                "label" => false,
                "required" => false,
                "attr" => [
                    "autofocus" => true
                ]
            ])
            ->add("next", "submit", [
                "label" => "Nästa nivå",
                "attr" => [
                    "class" => "btn-primary pull-right"
                ]
            ])
            ->getForm();
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

    private function createAdminForm(VaultLevel $level)
    {
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
