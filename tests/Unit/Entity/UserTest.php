<?php

namespace App\Tests\Entity;

use App\Entity\User;
use App\Entity\Review;
use App\Entity\Classe;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreateUser()
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testUserGettersAndSetters()
    {
        $user = new User();

        // Test getters and setters for properties
        $user->setUsername('testuser');
        $this->assertEquals('testuser', $user->getUsername());

        // Add similar tests for other properties

        // Test relationships
        $review = new Review();
        $user->addReview($review);
        $this->assertTrue($user->getReviews()->contains($review));

        // Add similar tests for other relationships
    }

    public function testUserVerificationStatus()
    {
        $user = new User();

        // Test initial verification status
        $this->assertFalse($user->isVerified());

        // Test setting verification status
        $user->setIsVerified(true);
        $this->assertTrue($user->isVerified());
    }

    public function testUserBanningStatus()
    {
        $user = new User();

        // Test initial banning status
        $this->assertFalse($user->isIsBanned());

        // Test setting banning status
        $user->setIsBanned(true);
        $this->assertTrue($user->isIsBanned());
    }

    public function testUserFullName()
    {
        $user = new User();
        $user->setFirstName('John');
        $user->setLastName('Doe');

        // Test full name generation
        $this->assertEquals('John Doe', $user->getName());
    }

    public function testUserReviewOperations()
    {
        $user = new User();
        $review = new Review();

        // Test adding review
        $user->addReview($review);
        $this->assertTrue($user->getReviews()->contains($review));

        // Test removing review
        $user->removeReview($review);
        $this->assertFalse($user->getReviews()->contains($review));
    }

    public function testUserRoles()
    {
        $user = new User();

        // Test initial roles
        $this->assertEquals(['ROLE_USER'], $user->getRoles());

        // Test adding roles
        $user->addRole('ROLE_ADMIN');
        $this->assertEquals(['ROLE_ADMIN','ROLE_USER'], $user->getRoles());

        

    }



}

