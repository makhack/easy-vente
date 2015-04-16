<?php

namespace Ev\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ev\FrontBundle\Entity\User;
use Ev\FrontBundle\Entity\Participants;

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
        
        $user = new User();
        $user->setConfirmationToken(uniqid());
        
        $formResgisterType = $this->get('ev_user_registration');

        $formResgister = $this->createForm($formResgisterType, $user);

        $formResgister->handleRequest($request);
        
        $data['Rform'] = $formResgister->createView();
        
        if($request->isMethod('POST') && $formResgister->isValid()) {
            
            if($this->get('fos_user.user_manager')->findUserByEmail($user->getEmail()))
            {
                
            }
            else
            {
                $em = $this->getDoctrine()->getManager();
                $em->persist($formResgister->getData());
                $em->flush();
                
                $uuser = $this->get('fos_user.user_manager')->findUserByEmail($user->getEmail());
                $url = $this->generateUrl('fos_user_registration_confirm', array('token' => $uuser->getConfirmationToken()), true);

                $message = \Swift_Message::newInstance()
                        ->setSubject('Registration confirmation')
                        ->setFrom('matthieugasnier95@gmail.com')
                        ->setTo($user->getEmail())
                        ->setContentType('text/html')
                        ->setBody(
                        $this->renderView(
                                "EvFrontBundle:mail:ConfirmationRegister.html.twig", array(
                            'user' => $user,
                            'confirmationUrl' => $url))
                        )
                ;
                $this->get('mailer')->send($message);
                
                return $this->redirect($this->generateUrl('ev_front_accueil_connected'));
            }

            unset($user);
            unset($formResgister);
            $user = new User();
            $formResgister = $this->createForm($formResgisterType, $user);
            
            
            return $this->render('EvFrontBundle:Default:index.html.twig',$data);
        }
        
        

        return $this->render('EvFrontBundle:Default:index.html.twig',$data);
    }
    
    
    public function connectedAction(Request $request)
    {
        $em = $this->getDoctrine()
                   ->getManager();
                   
        $slides = $em->createQuery('SELECT i FROM EvFrontBundle:Images i ORDER BY i.id')
                     ->setMaxResults(3)
                     ->setFirstResult(0)
                     ->getResult();
        
        $data['slides'] = $slides;
        
        return $this->render('EvFrontBundle:Default:indexConnected.html.twig',$data);
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
        
        foreach($produits as $produit){
            $image = $em->getRepository('EvFrontBundle:Images')->findOneById($produit->getImageId());
            
            $images[$produit->getId()] = $image;
        }
        
        $data['produits'] = $produits;
        
        $data['images'] = $images;
        
        return $this->render('EvFrontBundle:Default:best.html.twig', $data);
    }
    
    public function registerEventAction($idEvent, $idUser)
    {
        $em = $this->getDoctrine()->getManager();
        
        // On récupère le titre de l'événement pour le flashbag
        $event = $em->createQuery('SELECT e.nom FROM EvFrontBundle:Events e WHERE e.id = :id')
                    ->setParameter('id',$idEvent)
                    ->getResult();
        
        $eventName = $event[0]['nom'];
        
        // On vérifie si l'utilisateur n'est pas déjà inscrit
        $participation = $em->createQuery('SELECT p FROM EvFrontBundle:Participants p WHERE p.eventsId = :event AND p.usersId = :user')
                            ->setParameters(array(
                                'event' => $idEvent,
                                'user' => $idUser
                            ))->getResult();
        
        if(empty($participation)) {
            // On enregistre la demande de l'utilisateur
            $participant = new Participants();
            $participant->setEventsId($idEvent);
            $participant->setUsersId($idUser);
            $participant->setStatut(0);
        
            $em->persist($participant);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('success','Votre demande de participation à l\'événement '.$eventName.' a été enregistrée');
        } else {
            $this->get('session')->getFlashBag()->add('fail','Vous avez déjà demandé à participer à l\'événement '.$eventName);
        }
        
        return $this->redirect($this->generateUrl('ev_front_events'));
    }
}