<?php
// src/General/LoginBundle/DataFixtures/ORM/LoadCountryData.php

namespace General\LoginBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use General\LoginBundle\Entity\Country;

class LoadCountryData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $em)
    {
        for($i = 1; $i <= 200; $i++) {

        $country = new Country();
        $country->setName('United States' . $i);
        $country->setContinent('North America' . $i);
        $country->setRegion('North America' . $i);
        $country->setSurfaceArea('9827000' . $i);
        $country->setIndepYear('1776' . $i);
        $country->setPopulation('313000000' . $i);
        $country->setLifeExpectancy('78.64' . $i);
        $country->setGNP('15567' . $i);
        $country->setGNPOld('12345' . $i);
        $country->setLocalName('US' . $i);
        $country->setGovernmentform('Federal' . $i);
        $country->setHeadofstate('President' . $i);
        $country->setCapital('20000000' . $i);
        $country->setCode2('USA' . $i);

        $em->persist($country);

        }
        $em->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}