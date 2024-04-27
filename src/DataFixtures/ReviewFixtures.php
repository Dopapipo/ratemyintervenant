<?php

namespace App\DataFixtures;

use App\Entity\Matiere;
use App\Entity\Review;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ReviewFixtures extends Fixture implements OrderedFixtureInterface
{

    private AppFixtures $appFixtures;

    public function __construct(AppFixtures $appFixtures)
    {
        $this->appFixtures = $appFixtures;
    }


    public function load(ObjectManager $manager):void
    {
        $users = $manager->getRepository(User::class)->findNotAdmins();
        foreach ($users as $author) {
            $classe = $author->getClasse();
            $allIntervenantsParClasseAuteur = $classe->getIntervenants();
            foreach ($allIntervenantsParClasseAuteur as $intervenant) {
                $matieresDeIntervenantDansClasseAuteur = $intervenant->getMatieresEnseignees()->filter(fn(Matiere $matiere) => $matiere->getClasse() === $classe);
                foreach ($matieresDeIntervenantDansClasseAuteur as $matiere) {
                    $review = new Review();
                    $review->setMatiere($matiere);
                    $review->setAuthor($author);
                    $review->setGrade(random_int(1, 5));
                    $review->setContent($this->appFixtures->getFactory()::faker()->realText(300));
                    $review->setIntervenant($intervenant);
                    $manager->persist($review);

                }
            }
        }

        $manager->flush();
    }

    public function getOrder():int
    {
        return 5;
    }
}