<?php

namespace App\Tests\Entity;

use App\Entity\Classe;
use App\Entity\Intervenant;
use App\Entity\User;
use App\Entity\Matiere;
use PHPUnit\Framework\TestCase;

class ClasseTest extends TestCase
{
    public function testCreateClasse()
    {
        $classe = new Classe();
        $this->assertInstanceOf(Classe::class, $classe);
    }

    public function testClasseGettersAndSetters()
    {
        $classe = new Classe();

        // Test getters and setters for properties
        $classe->setName('Class A');
        $this->assertEquals('Class A', $classe->getName());

        // Test toString method
        $this->assertEquals('Class A', $classe->__toString());
    }

    public function testClasseStudents()
    {
        $classe = new Classe();
        $student = new User();

        // Test adding student
        $classe->addStudent($student);
        $this->assertTrue($classe->getStudents()->contains($student));

        // Test removing student
        $classe->removeStudent($student);
        $this->assertFalse($classe->getStudents()->contains($student));
    }

    public function testClasseIntervenants()
    {
        $classe = new Classe();
        $intervenant = new Intervenant();

        // Test adding intervenant
        $classe->addIntervenant($intervenant);
        $this->assertTrue($classe->getIntervenants()->contains($intervenant));

        // Test removing intervenant
        $classe->removeIntervenant($intervenant);
        $this->assertFalse($classe->getIntervenants()->contains($intervenant));
    }

    public function testClasseMatieres()
    {
        $classe = new Classe();
        $matiere = new Matiere();

        // Test adding matiere
        $classe->addMatiere($matiere);
        $this->assertTrue($classe->getMatieres()->contains($matiere));

        // Test removing matiere
        $classe->removeMatiere($matiere);
        $this->assertFalse($classe->getMatieres()->contains($matiere));
    }

    // Add more tests for other methods and edge cases
}

