<?php

namespace App\Tests\Entity;

use App\Entity\Intervenant;
use App\Entity\Classe;
use App\Entity\Matiere;
use App\Entity\Review;
use PHPUnit\Framework\TestCase;

class IntervenantTest extends TestCase
{
    public function testCreateIntervenant()
    {
        $intervenant = new Intervenant();
        $this->assertInstanceOf(Intervenant::class, $intervenant);
    }

    public function testIntervenantGettersAndSetters()
    {
        $intervenant = new Intervenant();

        // Test getters and setters for properties
        $intervenant->setName('John Doe');
        $this->assertEquals('John Doe', $intervenant->getName());

        $intervenant->setProfilePictureFileName('profile.jpg');
        $this->assertEquals('profile.jpg', $intervenant->getProfilePictureFileName());

        // Test image path method
        $this->assertEquals('uploads/profilePictures/profile.jpg', $intervenant->getImagePath());
    }

    public function testIntervenantReviews()
    {
        $intervenant = new Intervenant();
        $review = new Review();

        // Test adding review
        $intervenant->addReview($review);
        $this->assertTrue($intervenant->getReviews()->contains($review));

        // Test removing review
        $intervenant->removeReview($review);
        $this->assertFalse($intervenant->getReviews()->contains($review));
    }

    public function testIntervenantClassesTaught()
    {
        $intervenant = new Intervenant();
        $classe = new Classe();

        // Test adding class taught
        $intervenant->addClassesTaught($classe);
        $this->assertTrue($intervenant->getClassesTaught()->contains($classe));

        // Test removing class taught
        $intervenant->removeClassesTaught($classe);
        $this->assertFalse($intervenant->getClassesTaught()->contains($classe));
    }

    public function testIntervenantMatieresEnseignees()
    {
        $intervenant = new Intervenant();
        $matiere = new Matiere();

        // Test adding matiere taught
        $intervenant->addMatieresEnseignee($matiere);
        $this->assertTrue($intervenant->getMatieresEnseignees()->contains($matiere));

        // Test removing matiere taught
        $intervenant->removeMatieresEnseignee($matiere);
        $this->assertFalse($intervenant->getMatieresEnseignees()->contains($matiere));
    }

    public function testIntervenantId()
    {
        $intervenant = new Intervenant();

        // Test getting id
        $this->assertNull($intervenant->getId());
    }

}
