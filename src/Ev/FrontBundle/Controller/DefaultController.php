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
    
    public function nextAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        //$events = $em->getRepository('EvFrontBundle:Events')->findAll();
        
       $events = $em->createQuery(
                'SELECT e FROM EvFrontBundle:Events e
                WHERE e.date >= :date
                ORDER BY e.date ASC')
                ->setParameter('date',date('Y-m-d H:i:s'))->getResult();
        
        foreach ($events as $event) {
            $category = $em->getRepository('EvFrontBundle:Category')->findOneNameById($event->getCategoryId());
            $image  = $em->getRepository('EvFrontBundle:Images')->findOneById($event->getImageId());
            
            $event->setCategoryId($category);
            $event->setImageId($image);
            
            $eProduits = $em->getRepository('EvFrontBundle:EventsProduits')->findAllByEventId($event->getId());
            
            foreach ($eProduits as $eProduit) {
                $produit = $em->getRepository('EvFrontBundle:Produits')->findOneById($eProduit->getProduitsId());
                
                $image = $em->getRepository('EvFrontBundle:Images')->findOneById($produit->getImageId());
                
                //var_dump($image);
                $prodInfo[$event->getId()][] = array(
                    'name' => $produit->getNom(),
                    'image' => $image->getLien()
                );
            }
            
        }
        
        $data['products'] = $prodInfo;
        
        $pagination = $this->get('knp_paginator')
                           ->paginate($events, $request->query->get('page', 1),1);
      
        $data['pagination'] = $pagination;
        
        //var_dump($events);
        
        return $this->render('EvFrontBundle:Default:events.html.twig', $data);
    }
}