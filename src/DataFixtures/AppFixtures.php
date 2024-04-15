<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Intervenant;
use App\Entity\Matiere;
use App\Entity\Review;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private static $MINIMUM_INTERVENANTS = 3;
    private static $MAXIMUM_INTERVENANTS = 7;
    private static $MINIMUM_REVIEWS = 5;
    private static $MAXIMUM_REVIEWS = 20;
    private array $abbreviatons = [
        'L3 MIAGE CLASSIQUE' => 'L3Class',
        'L3 MIAGE APPRENTISSAGE' => 'L3App',
        'M1 MIAGE GR.1' => 'M1G1',
        'M1 MIAGE GR.2' => 'M1G2',
        'M2 MIAGE GR.1' => 'M2G1',
        'M2 MIAGE GR.2' => 'M2G2',
    ];
    private array $classes_matieres = [
        'L3 MIAGE CLASSIQUE' => [
            'Fondements de l\'algorithmique',
            'Programmation orientée objet',
            'Architecture des systemes informatiques',
            'Réseaux',
            'Bases de données avancées',
            'Gestion de projet',
            'Techniques de test et validation du logiciel',
            'Ingénierie de développement des IHM',
            'Comptabilité et Comptabilité analytique',
            'Techniques de communication',
            'Anglais',
            "Ateliers d'outils de développement",
            "Projet commun ou concours",
            "Technologies du Web: Remise a niveau"

        ],
        'L3 MIAGE APPRENTISSAGE' =>[
            'Fondements de l\'algorithmique',
            'Programmation orientée objet',
            'Architecture des systemes informatiques',
            'Réseaux',
            'Bases de données avancées',
            'Gestion de projet',
            'Techniques de test et validation du logiciel',
            'Ingénierie de développement des IHM',
            'Comptabilité et Comptabilité analytique',
            'Techniques de communication',
            'Anglais',
            "Ateliers d'outils de développement",
            "Projet commun ou concours",
            "Technologies du Web: Remise a niveau"

        ],
        'M1 MIAGE GR.1' => [],
        'M1 MIAGE GR.2' => [],
        'M2 MIAGE GR.1' => [],
        'M2 MIAGE GR.2' => [],
    ];
    private function formatClassesMatieres() :void{
        foreach ($this->abbreviatons as $classeName => $abbreviation) {
            $this->classes_matieres[$classeName] = $this->classes_matieres[$classeName] . ' ' . $abbreviation;
        }
    }
    public function load(ObjectManager $manager): void
    {
        //Classes & matieres
        $this->formatClassesMatieres();
        foreach ($this->classes_matieres as $classeName => $matieres) {
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

        //Intervenants
        foreach ($this->classes_matieres as $classeName => $matieres) {
            for ($i = 0; $i < random_int(self::$MINIMUM_INTERVENANTS,self::$MAXIMUM_INTERVENANTS); $i++) {
                $intervenant = new Intervenant();
                $classe = $manager->getRepository(Classe::class)->findOneBy(['name' => $classeName]);
                $intervenant->addClassesTaught($classe);
                $matiere = $manager->getRepository(Matiere::class)->findOneBy(['name' => $matieres[array_rand($matieres)]]);
                $intervenant->addMatieresEnseignee($matiere);
                $intervenant->setName('Intervenant '.$classeName.' '.$i);
                $manager->persist($intervenant);
            }
        }
        //Reviews
        $intervenants = $manager->getRepository(Intervenant::class)->findAll();

        foreach ($intervenants as $intervenant) {
            for ($i = 0; $i < random_int(self::$MINIMUM_REVIEWS,self::$MAXIMUM_REVIEWS); $i++) {
                $review = new Review();
                $review->setIntervenant($intervenant);
                $review->setMatiere($intervenant->getMatieresEnseignees()[random_int(0,count($intervenant->getMatieresEnseignees())-1)]);
                $review->setGrade(random_int(1,5));
                $review->setContent('Commentaire '.$i);
                $manager->persist($review);
            }
        }
    }
}
