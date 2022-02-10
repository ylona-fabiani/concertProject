<?php

namespace App\DataFixtures;

use App\Entity\Concert;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ConcertFixtures extends Fixture implements DependentFixtureInterface
{
    public const tour_names = ["Star80", "HellFest", "Musilac", "Lolapalooza", "VieillesCharrues"];

    public function load(ObjectManager $manager): void
    {
        foreach (range(0, 9) as $item) {
            $concert = new Concert();
            $concert->setTourName(self::tour_names[rand(0, count(self::tour_names)-1)]);
            $concert->setDate(\DateTime::createFromFormat("d/m/Y", rand(1,28) . '/' . rand(1,12) . "/" .  rand(2015,2030)));
            $concert->setHall($this->getReference(HallFixtures::venue_ref . HallFixtures::hall_name[rand(0, count(HallFixtures::hall_name)-1)]));
            $concert->addBand($this->getReference(BandFixtures::band_ref . BandFixtures::band_names[rand(0, count(BandFixtures::band_names)-1)]));
            $manager->persist($concert);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            HallFixtures::class,
            BandFixtures::class,
        ];
    }
}
