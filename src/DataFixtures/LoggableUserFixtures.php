<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class LoggableUserFixtures extends Fixture implements OrderedFixtureInterface
{

    private AppFixtures $appFixtures;

    public function __construct(AppFixtures $appFixtures)
    {
        $this->appFixtures = $appFixtures;
    }



    public function load(ObjectManager $manager):void
    {
        $admin = $manager->getRepository(User::class)->findOneBy(['username' => 'admin1']);
        if (!$admin) {
            $adminUser = UserFactory::new()->create([
                'username' => 'admin1',
                'password' => 'admin1',
                'roles' => ['ROLE_ADMIN', 'ROLE_USER'],
            ]);
        }

        foreach ($this->appFixtures->getAbbreviatons() as $classeName => $classeAbbreviation) {
            UserFactory::createOne([
                'username' => $classeAbbreviation,
                'password' => $classeAbbreviation,
                'roles' => ['ROLE_USER'],
                'classe' => $manager->getRepository(Classe::class)->findOneBy(['name' => $classeName]),
            ]);
        }
        $manager->flush();
    }

    public function getOrder():int
    {
        return 6;
    }
}