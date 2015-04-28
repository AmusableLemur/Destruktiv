<?php

namespace Destruktiv\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/forum")
 */
class ForumController extends Controller
{
    /**
     * @Route("/", name="forum")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
