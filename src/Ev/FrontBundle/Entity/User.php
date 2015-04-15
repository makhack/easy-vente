<?php

namespace Ev\FrontBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Validate;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 * 
 * class User
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * @Validate\NotBlank()
     * @ORM\Column( name="nom", type="string", length=255, nullable=true)
     */
    protected $nom;
    
    /**
     * @Validate\NotBlank()
     * @ORM\Column( name="prenom", type="string", length=255, nullable=true)
     */
    protected $prenom;
    function getNom() {
        return $this->nom;
    }

    function getPrenom() {
        return $this->prenom;
    }

    function setNom($nom) {
        $this->nom = $nom;
    }

    function setPrenom($prenom) {
        $this->prenom = $prenom;
    }


    
}