<?php

namespace AppBundle\Repository;

use AppBundle\Entity\City;
use Doctrine\ORM\EntityRepository;

class CityRepository extends EntityRepository
{
    /**
     * @return array
     */
    public function listOfAllCities()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT c.city FROM AppBundle:City c'
            )
            ->getResult();
    }

    /**
     * @param $city
     * @return City|null|object
     */
    public function findOneByName($city)
    {
        return $this->getEntityManager()
            ->getRepository(City::class)
            ->findOneBy(['city' => $city]);
    }

    public function randomCityFromDatabase() {
        return $this->getEntityManager()
            ->getRepository(City::class)
            ->findOneBy([]);
    }
}