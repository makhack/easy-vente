<?php

namespace Ev\UserBundle\Form\Type;

use Symfony\Component\Form\FormBuilderInterface;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class RegisterType extends BaseType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);
        
        $builder
            ->add('nom')->add('prenom')
            ->add('Submit', 'submit')
            ->add('email', 'email', array('label' => 'email :'))
            ->add('username', null, array('label' => 'username :'))
            ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Password :'),
                'second_options' => array('label' => 'Password Confirmation :'),
                'invalid_message' => 'fos_user.password.mismatch',
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ev\FrontBundle\Entity\User',
        ));
    }

    public function getName()
    {
        return 'register_form';
    }
}

