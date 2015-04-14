<?php

namespace Ev\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Participants
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ev\FrontBundle\Entity\ParticipantsRepository")
 */
class Participants
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="events_id", type="integer")
     */
    private $eventsId;

    /**
     * @var integer
     *
     * @ORM\Column(name="users_id", type="integer")
     */
    private $usersId;

    /**
     * @var boolean
     *
     * @ORM\Column(name="statut", type="boolean")
     */
    private $statut;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set eventsId
     *
     * @param integer $eventsId
     * @return Participants
     */
    public function setEventsId($eventsId)
    {
        $this->eventsId = $eventsId;

        return $this;
    }

    /**
     * Get eventsId
     *
     * @return integer 
     */
    public function getEventsId()
    {
        return $this->eventsId;
    }

    /**
     * Set usersId
     *
     * @param integer $usersId
     * @return Participants
     */
    public function setUsersId($usersId)
    {
        $this->usersId = $usersId;

        return $this;
    }

    /**
     * Get usersId
     *
     * @return integer 
     */
    public function getUsersId()
    {
        return $this->usersId;
    }

    /**
     * Set statut
     *
     * @param boolean $statut
     * @return Participants
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return boolean 
     */
    public function getStatut()
    {
        return $this->statut;
    }
}
