<?php

namespace App;

class RegisterHandler
{
   private $users = [];

   public function __construct($initialUsers = [])
   {
      $this->users = $initialUsers;
   }

   public function register($username, $password, $email)
   {
      if (empty($username) || empty($password) || empty($email)) {
         return false;
      }

      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
         return false;
      }

      foreach ($this->users as $user) {
         if ($user['username'] === $username || $user['email'] === $email) {
            return false;
         }
      }

      $this->users[] = [
         'username' => $username,
         'password' => password_hash($password, PASSWORD_BCRYPT),
         'email' => $email,
      ];

      return true;
   }
}
