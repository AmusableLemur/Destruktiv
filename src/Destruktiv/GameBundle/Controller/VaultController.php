<?php

namespace Destruktiv\GameBundle\Controller;

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
}
