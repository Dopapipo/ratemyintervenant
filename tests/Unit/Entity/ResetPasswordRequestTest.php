<?php

namespace App\Tests\Entity;

use App\Entity\ResetPasswordRequest;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ResetPasswordRequestTest extends TestCase
{

    public function testResetPasswordRequestUser()
    {
        $user = new User();
        $resetPasswordRequest = new ResetPasswordRequest($user, new \DateTime(), 'selector', 'hashedToken');

        // Test getting user
        $this->assertEquals($user, $resetPasswordRequest->getUser());
    }

    public function testResetPasswordRequestId()
    {
        $user = new User();
        $resetPasswordRequest = new ResetPasswordRequest($user, new \DateTime(), 'selector', 'hashedToken');

        // Test getting id
        $this->assertNull($resetPasswordRequest->getId());
    }

    public function testResetPasswordRequestInitialize()
    {
        $user = new User();
        $resetPasswordRequest = new ResetPasswordRequest($user, new \DateTime(), 'selector', 'hashedToken');

        // Test getting id
        $this->assertNull($resetPasswordRequest->getId());
    }

    public function testResetPasswordRequestUserType()
    {
        $user = new User();
        $resetPasswordRequest = new ResetPasswordRequest($user, new \DateTime(), 'selector', 'hashedToken');

        // Test getting user type
        $this->assertIsObject($resetPasswordRequest->getUser());
    }

}

