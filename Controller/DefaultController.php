<?php

namespace MESD\Presentation\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('MESDPresentationCalendarBundle:Default:index.html.twig', array('name' => $name));
    }
}
