<?php

namespace Ev\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('EvFrontBundle:Images');
        $slides = $repo->findAll();
        
        $data['slides'] = $slides;
        
        return $this->render('EvFrontBundle:Default:index.html.twig', $data);
    }
}