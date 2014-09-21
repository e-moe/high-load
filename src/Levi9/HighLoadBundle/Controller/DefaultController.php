<?php

namespace Levi9\HighLoadBundle\Controller;

use Levi9\HighLoadBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/show/{path}", name="")
     * @Cache(expires="15 minutes", public=true)
     * @param Student $student
     * @return Response
     */
    public function showAction(Student $student)
    {
        return $this->render('Levi9HighLoadBundle:Default:show.html.twig', ['student' => $student]);
    }
}
