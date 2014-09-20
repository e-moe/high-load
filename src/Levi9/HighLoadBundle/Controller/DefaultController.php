<?php

namespace Levi9\HighLoadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller
{
    /**
     * @Route("/show/{name}", name="")
     * @Cache(expires="15 minutes", public=true)
     */
    public function showAction($name)
    {
        return $this->render('Levi9HighLoadBundle:Default:show.html.twig', array('name' => $name));
    }
}
