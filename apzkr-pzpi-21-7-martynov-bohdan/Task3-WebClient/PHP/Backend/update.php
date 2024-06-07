<?php
session_start();
require "./db.php";
require "./languages/language.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   // Validate and sanitize the inputs
   $itemId = $_POST['id'];
   $itemName = $_POST['name'];
   $itemDescription = $_POST['description'];
   $itemGender = $_POST['gender'];
   $itemPartType = $_POST['part_type'];
   $itemType = $_POST['item_type'];
   $itemSizeShoulder = $_POST['size_shoulder'];
   $itemSizeChest = $_POST['size_chest'];
   $itemSizeSleeve = $_POST['size_sleeve'];
   $itemSizeHip = $_POST['size_hip'];
   $itemLengthSideSeam = $_POST['length_side_seam'];
   $itemSizeLength = $_POST['size_length'];

   // Check if a new image file is uploaded
   if (!empty($_FILES['image']['name'])) {
      $imageName = $_FILES['image']['name'];
      $imageTemp = $_FILES['image']['tmp_name'];
      $imagePath = "uploads/" . $imageName;

      if (move_uploaded_file($imageTemp, $imagePath)) {
         // File uploaded successfully
      } else {
         echo $text['err_file'];
         exit;
      }
   } elseif (!empty($_POST['old_image']) && file_exists($_POST['old_image'])) {
      // If no new image is uploaded, but the existing image path exists, keep the existing image path from the database
      $imagePath = $_POST['old_image'];
   } else {
      // Handle the case where no new image is uploaded and no existing image path is provided
      $imagePath = ""; // You may want to set a default image path or handle it based on your requirements
   }

   // Update the database record
   $sql = $conn->prepare("UPDATE clothing_items SET 
                        item_name = ?,
                        description = ?,
                        item_gender = ?,
                        item_part_type = ?,
                        item_type = ?,
                        item_size_shoulder = ?,
                        item_size_chest = ?,
                        item_size_sleeve = ?,
                        item_size_hip = ?,
                        item_length_side_seam = ?,
                        item_size_length = ?,
                        item_image = ?
                        WHERE id = ?");

   $sql->bind_param("ssssssssssssi", $itemName, $itemDescription, $itemGender, $itemPartType, $itemType, $itemSizeShoulder, $itemSizeChest, $itemSizeSleeve, $itemSizeHip, $itemLengthSideSeam, $itemSizeLength, $imageName, $itemId);

   if ($sql->execute()) {
      $_SESSION['message_edit_db'] = 'Товар успішно додано.';
      header("Location: ./index.php");
      exit;
   } else {
      echo $text['err'] . $sql->error;
   }

   $sql->close();
} else {
   echo $text['err_request'];
}

$conn->close();
