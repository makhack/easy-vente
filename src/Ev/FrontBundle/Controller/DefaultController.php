<?php

namespace Ev\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ev\FrontBundle\Entity\User;

class DefaultController extends Controller 
{
    public function indexAction(Request $request)
    {
        $repo = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('EvFrontBundle:Images');
        $slides = $repo->findAll();
        
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
        $repo = $this->getDoctrine()
                   ->getManager()
                   ->getRepository('EvFrontBundle:Images');
        $slides = $repo->findAll();
        
        $data['slides'] = $slides;
        
        return $this->render('EvFrontBundle:Default:indexConnected.html.twig',$data);
    }
}