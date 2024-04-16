<?php

namespace App\Tests\Entity;

use App\Entity\Contact;
use PHPUnit\Framework\TestCase;

class ContactTest extends TestCase
{
    public function testCreateContact()
    {
        $contact = new Contact();
        $this->assertInstanceOf(Contact::class, $contact);
    }

    public function testContactGettersAndSetters()
    {
        $contact = new Contact();

        // Test setters and getters for properties
        $contact->setName('John Doe');
        $this->assertEquals('John Doe', $contact->getName());

        $contact->setEmail('john@example.com');
        $this->assertEquals('john@example.com', $contact->getEmail());

        $message = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.';
        $contact->setMessage($message);
        $this->assertEquals($message, $contact->getMessage());

        $contact->setIsRead(true);
        $this->assertTrue($contact->isIsRead());

        $contact->setIsHidden(true);
        $this->assertTrue($contact->isIsHidden());
    }

    public function testContactIsRead()
    {
        $contact = new Contact();

        // Test initial read status
        $this->assertFalse($contact->isIsRead());

        // Test setting read status
        $contact->setIsRead(true);
        $this->assertTrue($contact->isIsRead());
    }

    public function testContactIsHidden()
    {
        $contact = new Contact();

        // Test initial hidden status
        $this->assertFalse($contact->isIsHidden());

        // Test setting hidden status
        $contact->setIsHidden(true);
        $this->assertTrue($contact->isIsHidden());
    }

}
