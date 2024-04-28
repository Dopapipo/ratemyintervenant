<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{

    private AppFixtures $appFixtures;

    public function __construct(AppFixtures $appFixtures)
    {
        $this->appFixtures = $appFixtures;
    }
    public function load(ObjectManager $manager):void
    {
        $this->loadUsers($manager);
    }

    private function loadUsers(ObjectManager $manager):void {
        UserFactory::createMany(AppFixtures::getNUMBEROFUSERS());
        $users = $manager->getRepository(User::class)->findNotAdmins();
        foreach ($users as $user) {
            $user->setClasse($manager->getRepository(Classe::class)->findAll()[random_int(0, count($this->appFixtures->getClassesMatieres()) - 1)]);
            $manager->persist($user);
        }

        $manager->flush();
    }

    public function getOrder():int
    {
    return 4;
    }




}