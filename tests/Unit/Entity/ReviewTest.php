<?php

namespace App\Tests\Entity;

use App\Entity\Review;
use App\Entity\User;
use App\Entity\Matiere;
use PHPUnit\Framework\TestCase;

class ReviewTest extends TestCase
{
    public function testCreateReview()
    {
        $review = new Review();
        $this->assertInstanceOf(Review::class, $review);
    }


    public function testReviewLikesAndDislikes()
    {
        $review = new Review();

        // Test initial likes and dislikes
        $this->assertEquals(0, $review->getLikes());
        $this->assertEquals(0, $review->getDislikes());

        // Test like() method
        $review->like();
        $this->assertEquals(1, $review->getLikes());

        // Test dislike() method
        $review->dislike();
        $this->assertEquals(1, $review->getDislikes());
    }

    public function testReviewUserLikesAndDislikes()
    {
        $review = new Review();
        $user = new User();

        // Test adding user that liked
        $review->addUserThatLiked($user);
        $this->assertTrue($review->getUsersThatLiked()->contains($user));

        // Test removing user that liked
        $review->removeUserThatLiked($user);
        $this->assertFalse($review->getUsersThatLiked()->contains($user));

        // Test adding user that disliked
        $review->addUserThatDisliked($user);
        $this->assertTrue($review->getUsersThatDisliked()->contains($user));

        // Test removing user that disliked
        $review->removeUserThatDisliked($user);
        $this->assertFalse($review->getUsersThatDisliked()->contains($user));
    }

    public function testReviewAuthorName()
    {
        $review = new Review();
        $user = new User();
        $user->setUsername('testuser');
        $review->setAuthor($user);

        // Test getting author's name
        $this->assertEquals('testuser', $review->getAuthorName());
    }

    public function testReviewMatiere()
    {
        $review = new Review();
        $matiere = new Matiere();
        $review->setMatiere($matiere);

        // Test getting matiere
        $this->assertEquals($matiere, $review->getMatiere());
    }

    public function testReviewContent()
    {
        $review = new Review();
        $review->setContent('test content');

        // Test getting content
        $this->assertEquals('test content', $review->getContent());
    }

}

