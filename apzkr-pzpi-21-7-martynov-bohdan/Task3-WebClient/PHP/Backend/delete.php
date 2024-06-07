<?php
session_start();
require "./db.php";
require "./languages/language.php";

// Проверка, передан ли идентификатор элемента для удаления
if (isset($_GET['id'])) {
   $itemId = $_GET['id'];

   // Запрос на удаление элемента из базы данных
   $sql = "DELETE FROM clothing_items WHERE id = $itemId";

   if ($conn->query($sql) === TRUE) {
      $_SESSION['message_delete_db'] = 'Товар успішно видалено.';
      header("Location: ./index.php");
      exit;
   } else {
      echo "Помилка: SQL запиту: "  . $sql . "<br>" . $conn->error;
   }
} else {
   echo "Помилка";
}
