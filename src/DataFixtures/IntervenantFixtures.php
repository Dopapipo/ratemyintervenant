<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Intervenant;
use App\Entity\Matiere;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class IntervenantFixtures extends Fixture implements OrderedFixtureInterface
{


    public function __construct(private readonly UserFactory $factory, private readonly AppFixtures $appFixtures){}

    public function load(ObjectManager $manager): void
    {
        foreach ($this->appFixtures->getClassesMatieres() as $classeName => $matieres) {
            for ($i = 0; $i < random_int(AppFixtures::getMINIMUMINTERVENANTSPARCLASSE(), AppFixtures::getMAXIMUMINTERVENANTSPARCLASSE()); $i++) {
                //Intervenant matieres between 1 and MAX_MATIERES_PAR_INTERVENANT
                $intervenant = new Intervenant();
                $classe = $manager->getRepository(Classe::class)->findOneBy(['name' => $classeName]);
                $intervenant->addClassesTaught($classe);
                $intervenant->setName($this->factory::faker()->name());
                $intervenant->setProfilePictureFileName('defaut-intervenant.jpg');

                for ($i = 0; $i < random_int(1, min(count($matieres), AppFixtures::getMAXMATIERESPARINTERVENANT())); $i++) {
                    $matiere = $manager->getRepository(Matiere::class)->findOneBy(['name' => $matieres[$i]]);
                    $intervenant->addMatieresEnseignee($matiere);
                }
                $manager->persist($intervenant);
            }
        }
        $manager->flush();
    }
    public function getOrder(): int
    {
        return 3;
        }
}