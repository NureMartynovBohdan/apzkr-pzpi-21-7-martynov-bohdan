<?php

use PHPUnit\Framework\TestCase;
use App\RegisterHandler;

class RegisterHandlerTest extends TestCase
{
   private $registerHandler;

   protected function setUp(): void
   {
      $initialUsers = [
         ['username' => 'existingUser', 'password' => '$2y$10$E1jhgJNkD2T/E8YqS.kU4Of1Hjb5N6w5CwYF2aUyjsRITMQeW/COG', 'email' => 'existinguser@example.com'],
         ['username' => 'anotherUser', 'password' => '$2y$10$y3Rs1TPbKkj4E8Xq3LkO6O/SoHg/Fu7dQ4k/W2YxiQ5CMRUgU5Qai', 'email' => 'anotheruser@example.com'],
      ];

      $this->registerHandler = new RegisterHandler($initialUsers);
   }

   public function testRegisterSuccess()
   {
      $username = 'newUser';
      $password = 'newPassword';
      $email = 'newuser@example.com';
      $result = $this->registerHandler->register($username, $password, $email);
      $this->assertTrue($result);
   }

   public function testRegisterFailureWithExistingUser()
   {
      $username = 'existingUser';
      $password = 'password';
      $email = 'existinguser@example.com';
      $result = $this->registerHandler->register($username, $password, $email);
      $this->assertFalse($result);
   }

   public function testEmptyUsername()
   {
      $username = '';
      $password = 'somePassword';
      $email = 'user@example.com';
      $result = $this->registerHandler->register($username, $password, $email);
      $this->assertFalse($result);
   }

   public function testEmptyPassword()
   {
      $username = 'someUser';
      $password = '';
      $email = 'user@example.com';
      $result = $this->registerHandler->register($username, $password, $email);
      $this->assertFalse($result);
   }

   public function testEmptyEmail()
   {
      $username = 'someUser';
      $password = 'somePassword';
      $email = '';
      $result = $this->registerHandler->register($username, $password, $email);
      $this->assertFalse($result);
   }

   public function testInvalidEmail()
   {
      $username = 'someUser';
      $password = 'somePassword';
      $email = 'invalid-email';
      $result = $this->registerHandler->register($username, $password, $email);
      $this->assertFalse($result);
   }
}
