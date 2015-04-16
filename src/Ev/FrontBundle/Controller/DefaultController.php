<?php

namespace Ev\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()
                   ->getManager();
                   
        $slides = $em->createQuery('SELECT i FROM EvFrontBundle:Images i ORDER BY i.id')
                     ->setMaxResults(3)
                     ->setFirstResult(0)
                     ->getResult();
        
        $data['slides'] = $slides;
        
        return $this->render('EvFrontBundle:Default:index.html.twig', $data);
    }
    
    public function nextAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        
        //$events = $em->getRepository('EvFrontBundle:Events')->findAll();
        
       $events = $em->createQuery(
                'SELECT e FROM EvFrontBundle:Events e
                WHERE e.endDate >= :date
                ORDER BY e.endDate ASC')
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
        
        return $this->render('EvFrontBundle:Default:events.html.twig', $data);
    }
    
    public function bestAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $produits = $em->createQuery('SELECT p FROM EvFrontBundle:Produits p ORDER BY p.stock ASC')
                    ->setMaxResults(10)
                    ->setFirstResult(0)
                    ->getResult();
        
        //var_dump($produits);
        
        foreach($produits as $produit){
            $image = $em->getRepository('EvFrontBundle:Images')->findOneById($produit->getImageId());
            
            $images[$produit->getId()] = $image;
        }
        
        $data['produits'] = $produits;
        
        $data['images'] = $images;
        
        //var_dump($images);
        
        return $this->render('EvFrontBundle:Default:best.html.twig', $data);
    }
}