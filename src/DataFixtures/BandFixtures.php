<?php

namespace App\DataFixtures;

use App\Entity\Band;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class BandFixtures extends Fixture implements DependentFixtureInterface
{
    public const band_ref = "BAND_REFERENCE";
    public const band_names = ["Twenty One Pilots", "Coldplay", "Imagine Dragons"];


    public function load(ObjectManager $manager): void
    {
        $b1 = new Band();
        $b1 -> setName("Twenty One Pilots");
        $this->addReference(self::band_ref . self::band_names[0], $b1);
        $manager->persist($b1);

        $b2 = new Band();
        $b2 -> setName("Imagine Dragons");
        $b2->addMember($this->getReference(ArtistsFixtures::artist_ref . "ShawnMendes"));
        $this->addReference(self::band_ref . self::band_names[2], $b2);
        $manager->persist($b2);

        $b3 = new Band();
        $b3 -> setName("Coldplay");
        $b3->addMember($this->getReference(ArtistsFixtures::artist_ref . "Angele"));
        $this->addReference(self::band_ref . self::band_names[1], $b3);
        $manager->persist($b3);


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ArtistsFixtures::class,
        ];
    }
}
