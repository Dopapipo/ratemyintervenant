<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Matiere;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ClasseMatiereFixtures extends Fixture implements OrderedFixtureInterface
{


    //appfixtures holds the reference to all the constants, and it is tedious to
    //add references to each constant using the intended system
    //Moreover, it's using primitive types and arrays so i'm not even sure we can add references to it
    public function __construct(private AppFixtures $appFixtures)
    {
    }
    public function load(ObjectManager $manager):void
    {
        foreach ($this->appFixtures->getClassesMatieres() as $classeName => $matieres) {
            $classe = new Classe();
            $classe->setName($classeName);
            $manager->persist($classe);
            foreach ($matieres as $matiereName) {
                $matiere = new Matiere();
                $matiere->setName($matiereName);
                $matiere->setClasse($classe);
                $manager->persist($matiere);
            }
        }
        $manager->flush();
    }
    public function getOrder():int {
        return 2;
    }
}