<?php

namespace Ev\FrontBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Events_Produits
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Ev\FrontBundle\Entity\Events_ProduitsRepository")
 */
class Events_Produits
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
     * @ORM\Column(name="produits_id", type="integer")
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
