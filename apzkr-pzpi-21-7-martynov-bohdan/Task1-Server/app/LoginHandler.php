<?php

namespace App;

require __DIR__ . '/db.php';

class LoginHandler
{
   private $db;

   public function __construct()
   {
      $this->db = getDbConnection();
   }

   private function validateCredentials($user_email, $password)
   {
      return !empty($user_email) && !empty($password);
   }

   public function processLogin($user_email, $password)
   {
      if (!$this->validateCredentials($user_email, $password)) {
         return 'Усі поля повинні бути заповнені';
      }

      $sql = "SELECT * FROM users WHERE user_email = ?";
      $stmt = $this->db->prepare($sql);
      $stmt->bind_param("s", $user_email);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows == 1) {
         $row = $result->fetch_assoc();
         if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            return ['success' => true, 'user_id' => $row['user_id'], 'user_name' => $row['user_name']];
         } else {
            return 'Невірний пароль.';
         }
      } else {
         return 'Користувач з таким email не знайден.';
      }
   }
}
