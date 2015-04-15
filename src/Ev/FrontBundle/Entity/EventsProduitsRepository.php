<?php

namespace Ev\FrontBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * EventsProduitsRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EventsProduitsRepository extends EntityRepository
{
      public function findAllByEventId($id)
    {
        return $this->getEntityManager()
                ->createQuery('SELECT e FROM EvFrontBundle:EventsProduits e WHERE e.eventsId = :id')
                ->setParameter('id', $id)
                ->getResult();
    }
}