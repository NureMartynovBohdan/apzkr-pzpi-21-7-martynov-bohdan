<?php
session_start();
require "./db.php";
require "./languages/language.php";

// Обработка данных формы входа
if (isset($_POST['submit'])) {
   $user_email = $_POST['user_email'];
   $password = $_POST['password'];

   if (empty($user_email) || empty($password)) {
      $_SESSION['message_err_log_pass'] = 'Усі поля повинні бути заповнені';
      header('Location: ./logInForm.php');
      exit();
   }

   // Создание SQL-запроса для получения пользователя с указанным email
   $sql = "SELECT * FROM users WHERE user_email = '$user_email'";
   $result = $conn->query($sql);

   if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
      $hashedPassword = $row['password'];

      // Проверка соответствия пароля
      if (password_verify($password, $hashedPassword)) {
         setcookie('user', $row['user_name'], time() + 3600, '/'); // Куки

         // Установка user_id в сессии
         $_SESSION['user_id'] = $row['user_id'];

         // Перенаправление
         header('Location: ./index.php');
         exit();
      } else {
         $_SESSION['message_err_log_pass'] = 'Невірний пароль.';
         header('Location: ./logInForm.php');
         exit();
      }
   } else {
      $_SESSION['message_err_log_email'] = 'Користувач з таким email не знайден.';
      header('Location: ./logInForm.php');
      exit();
   }
}

// Закрытие соединения с базой данных
$conn->close();
