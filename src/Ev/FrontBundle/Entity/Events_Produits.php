<?php

namespace Ev\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events_Produits
 */
class Events_Produits
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $eventsId;

    /**
     * @var integer
     */
    private $produitsId;


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
     * @return Events_Produits
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
     * Set produitsId
     *
     * @param integer $produitsId
     * @return Events_Produits
     */
    public function setProduitsId($produitsId)
    {
        $this->produitsId = $produitsId;

        return $this;
    }

    /**
     * Get produitsId
     *
     * @return integer 
     */
    public function getProduitsId()
    {
        return $this->produitsId;
    }
}
