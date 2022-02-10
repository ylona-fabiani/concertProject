<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user1 = new User();
        $user1->setEmail("davidbibi@gmail.com");
        $user1->setFirstName("David");
        $user1->setLastName("Bibi");
        $user1->setPassword($this->userPasswordHasher->hashPassword($user1, "toto"));
        $user1->setRoles([User::ROLE_ADMIN]);
        $manager->persist($user1);

        $user2 = new User();
        $user2->setEmail("ylonafbn@gmail.com");
        $user2->setFirstName("Ylo");
        $user2->setLastName("cmoi");
        $user2->setPassword($this->userPasswordHasher->hashPassword($user1, "titi"));
        $manager->persist($user2);

        $manager->flush();
    }

    private  $userPasswordHasher;

    /**
     * UserFixtures constructor.
     * @param UserPasswordHasherInterface $userPasswordHasher
     */
    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }
}
