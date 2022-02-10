<?php

namespace App\DataFixtures;

use App\Entity\Hall;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\This;

class HallFixtures extends Fixture
{
    public const venue_ref = "VENUE_REF_";
    public const hall_name = ["Salle_A", "Salle_B"];

    public function load(ObjectManager $manager): void
    {
        $v1 = new Hall();
        $v1->setCapacity(2000);
        $v1->setName("Salle_A");
        $this->addReference(self::venue_ref . self::hall_name[0], $v1);
        $manager->persist($v1);

        $v2 = new Hall();
        $v2->setCapacity(5000);
        $v2->setName("Salle_B");
        $this->addReference(self::venue_ref . self::hall_name[1], $v2);
        $manager->persist($v2);

        $manager->flush();
    }
}
