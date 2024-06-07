<?php
session_start();
require "./languages/language.php";
require "./db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {



   // Получение данных из формы регистрации
   $name = $_POST['name'];
   $email = $_POST['email'];
   $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Хешируем пароль
   $rfid = $_POST['rfid'];
   $client_gender = $_POST['client_gender'];
   $client_size_shoulder = $_POST['client_size_shoulder'];
   $client_size_chest = $_POST['client_size_chest'];
   $client_size_sleeve = $_POST['client_size_sleeve'];
   $client_size_hip = $_POST['client_size_hip'];
   $client_length_side_seam = $_POST['client_length_side_seam'];
   $client_size_length = $_POST['client_size_length'];

   // Поля якы потрыбно обовязково заповнити

   $fields = [
      'name' => 'Ім\'я',
      'email' => 'Пошта',
      'password' => 'Пароль',
      'rfid' => 'RFID'
   ];

   foreach ($fields as $field => $field_name) {
      if (empty($_POST[$field])) {
         $_SESSION['message_err_reg_client'] = "Поле \"$field_name\" повинно бути заповнене";
         header('Location: ./registerClientForm.php');
         exit();
      }
   }

   // Проверка, существует ли пользователь с такой почтой
   $checkUserQuery = $conn->prepare("SELECT * FROM client WHERE email = ?");
   $checkUserQuery->bind_param("s", $email);
   $checkUserQuery->execute();
   $resultEmail = $checkUserQuery->get_result();

   if ($resultEmail->num_rows > 0) {
      // Пользователь с такой почтой уже существует
      $_SESSION['message_err_reg_client'] = 'Користувач з такою поштою вже є.';
      header("Location: ./registerClientForm.php");
      exit;
   }
   // Проверка, существует ли пользователь с такой rfid
   $checkRFIDQuery = $conn->prepare("SELECT * FROM client_profile WHERE rfid = ?");
   $checkRFIDQuery->bind_param("s", $rfid);
   $checkRFIDQuery->execute();
   $resultRFID = $checkRFIDQuery->get_result();

   if ($resultRFID->num_rows > 0) {
      // RFID already exists
      $_SESSION['message_err_reg_client'] = 'Ця RFID вже існує.';
      header("Location: ./registerClientFform.php");
      exit;
   }

   // Добавление нового пользователя в базу данных
   $insertUserQuery = $conn->prepare("INSERT INTO client (name, email, password, admin_id) VALUES (?, ?, ?, ?)");
   $insertUserQuery->bind_param("sssi", $name, $email, $password, $admin_id);

   if ($insertUserQuery->execute()) {
      $client_id = $conn->insert_id; // Получение id нового клиента

      // Добавление информации о размерах в другую таблицу
      $insertSizeQuery = $conn->prepare("INSERT INTO client_profile (id, rfid, client_gender, client_size_shoulder, client_size_chest, client_size_sleeve, client_size_hip, client_length_side_seam, client_size_length) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $insertSizeQuery->bind_param("iisiiiiii", $client_id, $rfid, $client_gender, $client_size_shoulder, $client_size_chest, $client_size_sleeve, $client_size_hip, $client_length_side_seam, $client_size_length);

      if ($insertSizeQuery->execute()) {
         $_SESSION['message_succes'] = "Реєстрація пройшла успішно.";
         header("Location: ./registerClientForm.php");
         exit;
      } else {
         $_SESSION['message_err_reg_client'] = 'Некорректне значення розміру.' . $conn->error;
         header("Location: ./registerClientForm.php");
         exit;
      }
   } else {
      $_SESSION['message_err_reg_client'] = 'Помилка' . $conn->error;
      header("Location: ./registerClientForm.php");
      exit;
   }
} else {
   // Некорректный запрос
   header("Location: ./registerClientForm.php");
   exit;
   if ($rfid !== 10) {
      $_SESSION['message_err_reg_client'] = 'Некорректне значення RFID.';
      header("Location: ./registerClientForm.php");
      exit;
   }
}

$conn->close();
