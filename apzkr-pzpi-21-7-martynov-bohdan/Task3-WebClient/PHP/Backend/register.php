<?php
session_start();
require "./db.php";
require "./languages/language.php";

// Обработка данных формы регистрации
if (isset($_POST['submit'])) {
   $user_name = $_POST['user_name'];
   $user_email = $_POST['user_email'];
   $password = $_POST['password'];

   // Проверка, что поля не пустые
   if (empty($user_name) || empty($user_email) || empty($password)) {
      $_SESSION['message_err_reg_user'] = 'Усі поля повинні бути заповнені';
      header('Location: ./registerForm.php');
      exit();
   }

   // Проверка, что пароль содержит не менее 6 символов
   if (strlen($password) < 6) {
      $_SESSION['message_err_reg_user'] = 'Пароль має містити не менше 6 символів.';
      header('Location: ./registerForm.php');
      exit();
   }

   // Проверка, что пользователь с таким email уже не существует
   $sql = "SELECT * FROM users WHERE user_email = '$user_email'";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
      $_SESSION['message_err_reg_user'] = 'Користувач з таким email не знайден.';
      header('Location: ./registerForm.php');
      exit();
   }

   // Хэширование пароля
   $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

   // Создание SQL-запроса для вставки нового пользователя
   $sql = "INSERT INTO users (user_name, user_email, password, role) VALUES ('$user_name', '$user_email', '$hashedPassword', 'admin' )";

   if ($conn->query($sql) === TRUE) {
      // Получение user_id только что добавленного пользователя
      $newUserId = $conn->insert_id;

      // Сохранение user_id в сессии   
      $_SESSION['user_id'] = $newUserId;
      // Установка куки для пользователя
      setcookie('user', $user_name, time() + 3600, "/"); // Куки 
      header('Location: ./index.php');
   } else {
      $_SESSION['message_err_reg_user'] = 'Помилка';
      header('Location: ./registerForm.php');
   }
}

// Закрытие соединения с базой данных
$conn->close();
