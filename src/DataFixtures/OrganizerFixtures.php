<?php

namespace App\DataFixtures;

use App\Entity\Organizer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class OrganizerFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $orga = new Organizer();
        $orga->setName("Paloma");
        $orga->setTel("0467123456");
        $orga->setAdress("250 chemin l'aérodrome");
        $orga->setZipcode(30000);
        $orga->setTown("Nîmes");

        $manager->persist($orga);
        $manager->flush();
    }
}
