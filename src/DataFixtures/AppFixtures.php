<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Intervenant;
use App\Entity\Matiere;
use App\Entity\Review;
use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private static $MINIMUM_INTERVENANTS_PAR_CLASSE = 3;
    private static $MAXIMUM_INTERVENANTS_PAR_CLASSE = 7;
    private static $NUMBER_OF_USERS = 50;
    private static $MAX_MATIERES_PAR_INTERVENANT = 4;
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
        'L3 MIAGE APPRENTISSAGE' => [
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
        'M1 MIAGE GR.1' => [
            "Ingénierie des systèmes d'information",
            "Ingénierie des processus métiers",
            "Ingénierie des données",
            "Ingénierie des services",
            "Ingénierie des applications",
        ],
        'M1 MIAGE GR.2' => ["Ingénierie des systèmes d'information",
            "Ingénierie des processus métiers",
            "Ingénierie des données",
            "Ingénierie des services",
            "Ingénierie des applications",],
        'M2 MIAGE GR.1' => ["Ingénierie des systèmes d'information",
            "Ingénierie des processus métiers",
            "Ingénierie des données",
            "Ingénierie des services",
            "Ingénierie des applications",],
        'M2 MIAGE GR.2' => ["Ingénierie des systèmes d'information",
            "Ingénierie des processus métiers",
            "Ingénierie des données",
            "Ingénierie des services",
            "Ingénierie des applications",],
    ];

    public function __construct(private readonly UserFactory $factory) //UserFactory pour l'autowiring
        //(juste besoin des méthodes de l'interface, mais symfony ne l'autowire pas....
    {
    }

    public function load(ObjectManager $manager): void
    {
        $this->formatClassesMatieres();
        //Classes & matieres
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
        $manager->flush();

        //Intervenants
        foreach ($this->classes_matieres as $classeName => $matieres) {
            for ($i = 0; $i < random_int(self::$MINIMUM_INTERVENANTS_PAR_CLASSE, self::$MAXIMUM_INTERVENANTS_PAR_CLASSE); $i++) {
                //Intervenant matieres between 1 and MAX_MATIERES_PAR_INTERVENANT
                $intervenant = new Intervenant();
                $classe = $manager->getRepository(Classe::class)->findOneBy(['name' => $classeName]);
                $intervenant->addClassesTaught($classe);
                $intervenant->setName($this->factory::faker()->name());
                $intervenant->setProfilePictureFileName('default-intervenant.jpg');

                for ($i = 0; $i < random_int(1, min(count($matieres), self::$MAX_MATIERES_PAR_INTERVENANT)); $i++) {
                    $matiere = $manager->getRepository(Matiere::class)->findOneBy(['name' => $matieres[$i]]);
                    $intervenant->addMatieresEnseignee($matiere);
                }
                $manager->persist($intervenant);
            }
        }
        $manager->flush();

        //Users
        UserFactory::createMany(self::$NUMBER_OF_USERS);
        $users = $manager->getRepository(User::class)->findAll();
        foreach ($users as $user) {
            $user->setClasse($manager->getRepository(Classe::class)->findAll()[random_int(0, count($this->classes_matieres) - 1)]);
            $manager->persist($user);
        }
        $admin = $manager->getRepository(User::class)->findOneBy(['username' => 'admin1']);
        if (!$admin) {
            $adminUser = UserFactory::new()->create([
                'username' => 'admin1',
                'password' => 'admin1',
                'roles' => ['ROLE_ADMIN', 'ROLE_USER'],]);
        }
        //Reviews
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
                    $review->setContent($this->factory::faker()->realText(300));
                    $review->setIntervenant($intervenant);
                    $classe = $author->getClasse();
                    $manager->persist($review);

                }
            }
        }

        $manager->flush();

    }

    private function formatClassesMatieres(): void
    {
        foreach ($this->abbreviatons as $classeName => $abbreviation) {
            for ($i = 0; $i < count($this->classes_matieres[$classeName]); $i++) {
                $this->classes_matieres[$classeName][$i] = $this->classes_matieres[$classeName][$i] . ' ' . $abbreviation;
            }
        }
    }
}
