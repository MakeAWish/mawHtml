<?php

namespace Sch\WlBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class WishController extends Controller
{
    /**
     * @Route("/wish")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }
}
