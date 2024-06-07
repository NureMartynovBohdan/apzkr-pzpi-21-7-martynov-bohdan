<?php

namespace App;

require __DIR__ . '/db.php';

class AddItemHandler
{
   private $items;
   private $uploadedImages;

   public function __construct($items = [], $uploadedImages = [])
   {
      $this->items = $items;
      $this->uploadedImages = $uploadedImages;
   }

   private function validateInput($name, $description)
   {
      return !empty($name) && !empty($description);
   }

   private function uploadImage($image)
   {
      $fakeImageName = basename($image["name"]);
      $this->uploadedImages[] = $fakeImageName;
      return $fakeImageName;
   }

   public function processAddItem($name, $description, $gender, $partType, $itemType, $sizeShoulder, $sizeChest, $sizeSleeve, $sizeHip, $lengthSideSeam, $sizeLength, $image)
   {
      if (!$this->validateInput($name, $description)) {
         return 'Item name and description are required.';
      }

      $uploadedImage = $this->uploadImage($image);
      if (!$uploadedImage) {
         return 'Failed to upload image.';
      }

      $currentAdminId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

      $item = [
         'name' => $name,
         'description' => $description,
         'gender' => $gender,
         'partType' => $partType,
         'itemType' => $itemType,
         'sizeShoulder' => $sizeShoulder,
         'sizeChest' => $sizeChest,
         'sizeSleeve' => $sizeSleeve,
         'sizeHip' => $sizeHip,
         'lengthSideSeam' => $lengthSideSeam,
         'sizeLength' => $sizeLength,
         'image' => $uploadedImage,
         'adminId' => $currentAdminId
      ];

      $this->items[] = $item;

      return 'Item added successfully.';
   }
}
