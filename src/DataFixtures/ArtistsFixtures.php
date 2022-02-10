<?php

namespace App\DataFixtures;

use App\Entity\Artists;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArtistsFixtures extends Fixture
{
    public const artist_ref = 'ARTIST_REFERENCE_';

    public $first_names = ['David', 'Elie', 'Axel', 'Julien', 'Clement', 'Ylona'];
    public $last_names = ['Bieber', 'Mendes', 'The Kid', 'Nas X', 'Mars', 'Sheeran'];

    public function load(ObjectManager $manager): void
    {
        $a1 = new Artists();
        $a1->setSceneName("Shawn Mendes");
        $this->addReference(self::artist_ref . "ShawnMendes", $a1);
        $manager->persist($a1);

        $a2 = new Artists();
        $a2->setSceneName("Angele");
        $this->addReference(self::artist_ref . "Angele", $a2);
        $manager->persist($a2);

        $a3 = new Artists();
        $a3->setSceneName("Lomepal");
        $this->addReference(self::artist_ref . "Lomepal", $a3);
        $manager->persist($a3);

        $manager->flush();
    }
}
