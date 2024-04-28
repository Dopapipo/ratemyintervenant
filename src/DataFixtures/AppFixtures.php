<?php

namespace App\DataFixtures;

use App\Entity\Classe;
use App\Entity\Intervenant;
use App\Entity\Matiere;
use App\Entity\Review;
use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture implements OrderedFixtureInterface
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
            'Architecture des systèmes informatiques',
            "Fondement de l'Algorithmique",
            'Programmation orientée objet (POO)',
            'Réseaux',
            'Ingénierie de développement des IHM',
            "Méthodes d'ingénierie des SI: Fondamentaux",
            'Comptabilité & comptabilité analytique',
            'Techniques de test et validation du logiciel',
            'Anglais',
            'Ateliers "outils de développement',
            'Techniques de communication',
            "Algorithmique avancée",
            "Technologie du Web: niveau avancé",
            "Architecture Orientée Objet",
            "Gestion de projets: Fondamentaux",
            "Bases de la RO et de l'optimisation",
            "Programmation des BD relationnelles",
            "Ressources Humaines et Marketing",
            "Anglais",
            "Ateliers outils de développement mobiles",
            "Mission d'analyse et de développement",
            "Projet commun ou concours",
            "Techniques de communication",
            "Atelier lié à la créativité",
            "Atelier Positionnement Projet Professionnel"

        ],
        'L3 MIAGE APPRENTISSAGE' => [
            'Architecture des systèmes informatiques',
            "Fondement de l'Algorithmique",
            'Programmation orientée objet (POO)',
            'Réseaux',
            'Ingénierie de développement des IHM',
            "Méthodes d'ingénierie des SI: Fondamentaux",
            'Comptabilité & comptabilité analytique',
            'Techniques de test et validation du logiciel',
            'Anglais',
            'Ateliers "outils de développement',
            'Techniques de communication',
            "Algorithmique avancée",
            "Technologie du Web: niveau avancé",
            "Architecture Orientée Objet",
            "Gestion de projets: Fondamentaux",
            "Bases de la RO et de l'optimisation",
            "Programmation des BD relationnelles",
            "Ressources Humaines et Marketing",
            "Anglais",
            "Ateliers outils de développement mobiles",
            "Mission d'analyse et de développement",
            "Projet commun ou concours",
            "Techniques de communication",
            "Atelier lié à la créativité",
            "Atelier Positionnement Projet Professionnel"

        ],

        'M1 MIAGE GR.1' => [
            "Gestion de projet avancée",
            "Modèles de l'ingénierie des SI",
            "Architectures logicielles et Web",
            "Frameworks, composants métiers et Web service",
            "Contrôle de gestion",
            "Droit",
            "Graphes et algoritmes",
            "Marketing digital",
            "Méthodes statistiques",
            "Anglais",
            "Séminaire thématique",
            "Atelier Veille technologique",
            "Techniques de communication",
            "Bases de données non SQL",
            "Outils d'analyse de documents structurés",
            "Modèles et outils pour les processus",
            "Modélisation événementielle et ses implémentations",
            "Initiation aux stratégies d'entreprises dans les TIC",
            "Techniques mathématiques pour l'aide à la décision",
            "Anglais (préparation certification)",
            "Mémoire et mission",
            "Projet commun ou concours",
            "Techniques de communication",
        ],
        'M1 MIAGE GR.2' => [
            "Gestion de projet avancée",
            "Modèles de l'ingénierie des SI",
            "Architectures logicielles et Web",
            "Frameworks, composants métiers et Web service",
            "Contrôle de gestion",
            "Droit",
            "Graphes et algoritmes",
            "Marketing digital",
            "Méthodes statistiques",
            "Anglais",
            "Séminaire thématique",
            "Atelier Veille technologique",
            "Techniques de communication",
            "Bases de données non SQL",
            "Outils d'analyse de documents structurés",
            "Modèles et outils pour les processus",
            "Modélisation événementielle et ses implémentations",
            "Initiation aux stratégies d'entreprises dans les TIC",
            "Techniques mathématiques pour l'aide à la décision",
            "Anglais (préparation certification)",
            "Mémoire et mission",
            "Projet commun ou concours",
            "Techniques de communication",
        ],
        'M2 MIAGE GR.1' => [
            "Ingénierie avancée des processus",
            "Ingénierie dirigée par les modèles",
            "Méthodes de recherche",
            "Séminaire thématique",
            "Architecture d'entreprise basée sur les services : partie 1",
            "Architecture d'entreprise basée sur les services : partie 2",
            "Blockchain",
            "Cloud & pervasive computing",
            "Fouille de processus",
            "Informatique décisionnelle",
            "Ingénierie & management de la connaissance",
            "Ingénierie des exigences",
            "Machine Learning",
            "Raisonnement par contraintes et ses applications",
            "Sécurité & qualité des SI",
            "Variabilité, ligne de produits et fabrique logicielle",
            "Mémoire de Master, Entreprenariat & Stage/Alternance",
        ],
        'M2 MIAGE GR.2' => [
            "Ingénierie avancée des processus",
            "Ingénierie dirigée par les modèles",
            "Méthodes de recherche",
            "Séminaire thématique",
            "Architecture d'entreprise basée sur les services : partie 1",
            "Architecture d'entreprise basée sur les services : partie 2",
            "Blockchain",
            "Cloud & pervasive computing",
            "Fouille de processus",
            "Informatique décisionnelle",
            "Ingénierie & management de la connaissance",
            "Ingénierie des exigences",
            "Machine Learning",
            "Raisonnement par contraintes et ses applications",
            "Sécurité & qualité des SI",
            "Variabilité, ligne de produits et fabrique logicielle",
            "Mémoire de Master, Entreprenariat & Stage/Alternance",
        ],
    ];
    private bool $formatted = false;

    public function __construct(private readonly UserFactory $factory) //UserFactory pour l'autowiring
    //(juste besoin des méthodes de l'interface, mais symfony ne l'autowire pas....
    {
    }
    /*
     * Order is based on dependencies, the order of the fixtures is important
     * Could have specified dependencies directly but this works nicely aswell
     */
    public function load(ObjectManager $manager): void
    {
        $this->formatClassesMatieres();
    }

    private function formatClassesMatieres(): void
    {   if ($this->formatted) {
        return;
    }
        foreach ($this->abbreviatons as $classeName => $abbreviation) {
            for ($i = 0; $i < count($this->classes_matieres[$classeName]); $i++) {
                $this->classes_matieres[$classeName][$i] = $this->classes_matieres[$classeName][$i] . ' ' . $abbreviation;
            }
        }
        $this->formatted = true;
    }
    /**
     * @return array
     */
    public function getClassesMatieres(): array
    {
        return $this->classes_matieres;
    }

    public function getOrder()
    {
        return 1;
    }

    /**
     * @return array
     */
    public function getAbbreviatons(): array
    {
        return $this->abbreviatons;
    }

    /**
     * @return UserFactory
     */
    public function getFactory(): UserFactory
    {
        return $this->factory;
    }
    public static function getMINIMUMINTERVENANTSPARCLASSE(): int
    {
        return self::$MINIMUM_INTERVENANTS_PAR_CLASSE;
    }

    public static function getMAXIMUMINTERVENANTSPARCLASSE(): int
    {
        return self::$MAXIMUM_INTERVENANTS_PAR_CLASSE;
    }

    public static function getNUMBEROFUSERS(): int
    {
        return self::$NUMBER_OF_USERS;
    }

    public static function getMAXMATIERESPARINTERVENANT(): int
    {
        return self::$MAX_MATIERES_PAR_INTERVENANT;
    }

    public static function getMINIMUMREVIEWS(): int
    {
        return self::$MINIMUM_REVIEWS;
    }

    public static function getMAXIMUMREVIEWS(): int
    {
        return self::$MAXIMUM_REVIEWS;
    }
}
