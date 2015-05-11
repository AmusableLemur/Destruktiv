<?php

namespace Destruktiv\CommunityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        $threadRepo = $em->getRepository("DestruktivForumBundle:Thread");
        $threads = $threadRepo->createQueryBuilder("t")
            ->orderBy("t.dateUpdated", "DESC")
            ->setMaxResults(5)
            ->getQuery()
            ->getResult();

        return [
            "threads" => $threads,
            "page"    => "home"
        ];
    }
}
