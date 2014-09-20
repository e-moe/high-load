<?php

namespace Levi9\HighLoadBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;

class DefaultController extends Controller
{
    /**
     * @Route("/show/{path}", name="")
     * @Cache(expires="15 minutes", public=true)
     */
    public function showAction($path)
    {
        $student = $this->get('doctrine')->getRepository('Levi9HighLoadBundle:Student')->findOneBy(
            array(
                'path' => $path
            )
        );
        if (null === $student) {
            throw $this->createNotFoundException();
        }
        return $this->render('Levi9HighLoadBundle:Default:show.html.twig', array('student' => $student));
    }
}
