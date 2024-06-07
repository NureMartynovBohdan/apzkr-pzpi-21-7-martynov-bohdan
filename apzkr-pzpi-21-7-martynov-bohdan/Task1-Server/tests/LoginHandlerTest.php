<?php

use App\LoginHandler;

class LoginHandlerTest extends \PHPUnit\Framework\TestCase
{
   private $loginHandler;
   private $db;

   protected function setUp(): void
   {
      $this->db = $this->createMock(mysqli::class);
      $this->loginHandler = new LoginHandler($this->db);
   }

   public function testProcessLoginEmptyFields()
   {
      $result = $this->loginHandler->processLogin("", "");
      $this->assertEquals('Усі поля повинні бути заповнені', $result);
   }

   public function testProcessLoginIncorrectPassword()
   {
      $stmt = $this->createMock(mysqli_stmt::class);
      $this->db->method('prepare')->willReturn($stmt);
      $stmt->method('execute');

      $stmt->method('get_result')->willReturnCallback(function () {
         return new class
         {
            public $num_rows = 1;
            public function fetch_assoc()
            {
               return ['password' => password_hash('123456', PASSWORD_DEFAULT), 'user_id' => '13', 'user_name' => 'test'];
            }
         };
      });

      $response = $this->loginHandler->processLogin("test123456@gmail.com", "12345");
      $this->assertEquals('Невірний пароль.', $response);
   }

   public function testProcessLoginSuccess()
   {
      $stmt = $this->createMock(mysqli_stmt::class);
      $this->db->method('prepare')->willReturn($stmt);
      $stmt->method('execute');

      $stmt->method('get_result')->willReturnCallback(function () {
         return new class
         {
            public $num_rows = 1;
            public function fetch_assoc()
            {
               return ['password' => password_hash('123456', PASSWORD_DEFAULT), 'user_id' => '13', 'user_name' => 'test'];
            }
         };
      });

      $response = $this->loginHandler->processLogin("test123456@gmail.com", "123456");
      $this->assertEquals(['success' => true, 'user_id' => '13', 'user_name' => 'test'], $response);
   }
}
