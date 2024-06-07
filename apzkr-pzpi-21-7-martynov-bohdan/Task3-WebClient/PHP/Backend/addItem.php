<?php
//adItem.php - beck
session_start();
require "./db.php";
require "./languages/language.php";

// Проверка, была ли отправлена форма
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Получение данных из формы
   $name = $_POST["name"];
   $description = $_POST['description'];
   $gender = $_POST["gender"];
   $partType = $_POST["part_type"];
   $itemType = $_POST["item_type"];
   $sizeShoulder = $_POST["size_shoulder"];
   $sizeChest = $_POST["size_chest"];
   $sizeSleeve = $_POST["size_sleeve"];
   $sizeHip = $_POST["size_hip"];
   $lengthSideSeam = $_POST["length_side_seam"];
   $sizeLength = $_POST["size_length"];

   // Получение admin_id из сессии или вашей системы аутентификации
   $currentAdminId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

   // Обработка изображения
   $image = $_FILES["image"]["name"];
   $target_dir = "uploads/";
   $target_file = $target_dir . basename($image);

   // Загрузка изображения на сервер
   if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
      // Вставка данных в базу данных
      $sql = "INSERT INTO clothing_items (item_name, description, item_gender, item_part_type, item_type, item_size_shoulder, item_size_chest, item_size_sleeve, item_size_hip, item_length_side_seam, item_size_length, item_image, admin_id)
        VALUES ('$name','$description', '$gender', '$partType', '$itemType', '$sizeShoulder', '$sizeChest', '$sizeSleeve', '$sizeHip', '$lengthSideSeam', '$sizeLength', '$image', '$currentAdminId')";

      if ($conn->query($sql) === TRUE) {
         $_SESSION['message_add_db'] = 'Товар успішно додано.';
         header('Location: ./addItemForm.php');
         exit;
      } else {
         echo "Помилка: " . $sql . "<br>" . $conn->error;
      }
   } else {
      $_SESSION['message_err_add_img'] = 'Додайте зображення.';
      header('Location: ./addItemForm.php');
      exit;
   }


   // Закрытие соединения с базой данных
   $conn->close();
}
