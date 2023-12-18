<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



class SuperAdminFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }
    public function load(ObjectManager $manager): void
    {
        $superAdmin = $this->createSuperAdmin();
        $manager->persist($superAdmin);        

        $manager->flush();
    }

    private function createSuperAdmin() : User 
    {
        $superAdmin = new User();

        $superAdmin->setFirstName("Matt");
        $superAdmin->setLastName("Faucheux");
        $superAdmin->setEmail("medecin-du-monde@gmail.com");
        $superAdmin->setRoles(["Role_SUPER_ADMIN", "ROLE_ADMIN", "ROLE_USER"]);

        $passwordHashed = $this->hasher->hashPassword($superAdmin, "Azerty1234*");
        $superAdmin->setPassword($passwordHashed);
        $superAdmin->setIsVerified(true);

        $superAdmin->setCreatedAt(new DateTimeImmutable());
        $superAdmin->setVerifiedAt(new DateTimeImmutable());
        $superAdmin->setUpdatedAt(new DateTimeImmutable());

        return $superAdmin;
    }
}
