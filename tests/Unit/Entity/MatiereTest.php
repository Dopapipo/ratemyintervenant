<?php

namespace App\Tests\Entity;

use App\Entity\Matiere;
use App\Entity\Intervenant;
use App\Entity\Classe;
use PHPUnit\Framework\TestCase;

class MatiereTest extends TestCase
{
    public function testCreateMatiere()
    {
        $matiere = new Matiere();
        $this->assertInstanceOf(Matiere::class, $matiere);
    }

    public function testMatiereGettersAndSetters()
    {
        $matiere = new Matiere();

        // Test getters and setters for properties
        $matiere->setName('Mathematics');
        $this->assertEquals('Mathematics', $matiere->getName());

        // Test toString method
        $this->assertEquals('Mathematics', $matiere->__toString());
    }

    public function testMatiereIntervenants()
    {
        $matiere = new Matiere();
        $intervenant = new Intervenant();

        // Test adding intervenant
        $matiere->addIntervenant($intervenant);
        $this->assertTrue($matiere->getIntervenants()->contains($intervenant));

        // Test removing intervenant
        $matiere->removeIntervenant($intervenant);
        $this->assertFalse($matiere->getIntervenants()->contains($intervenant));
    }

    public function testMatiereClasse()
    {
        $matiere = new Matiere();
        $classe = new Classe();

        // Test setting and getting classe
        $matiere->setClasse($classe);
        $this->assertEquals($classe, $matiere->getClasse());

        // Test removing classe
        $matiere->setClasse(null);
        $this->assertNull($matiere->getClasse());
    }

    public function testMatiereReviews()
    {
        $matiere = new Matiere();

        // Test initial reviews
        $this->assertCount(0, $matiere->getReviews());
    }

    public function testMatiereId()
    {
        $matiere = new Matiere();

        // Test getting id
        $this->assertNull($matiere->getId());
    }

    public function testMatiereInitialize()
    {
        $matiere = new Matiere();

        // Test getting id
        $this->assertNull($matiere->getId());
    }

}

