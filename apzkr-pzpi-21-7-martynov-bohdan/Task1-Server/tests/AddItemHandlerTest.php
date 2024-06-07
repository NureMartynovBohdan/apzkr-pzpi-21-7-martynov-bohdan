<?php

use PHPUnit\Framework\TestCase;
use App\AddItemHandler;

class AddItemHandlerTest extends TestCase
{
   private $addItemHandler;

   protected function setUp(): void
   {
      $this->addItemHandler = new AddItemHandler();
      $_SESSION['user_id'] = 1; // Имитация авторизованного администратора
   }

   public function testProcessAddItemSuccess()
   {
      $name = 'Item1';
      $description = 'Description1';
      $gender = 'Male';
      $partType = 'Upper';
      $itemType = 'Shirt';
      $sizeShoulder = 'M';
      $sizeChest = 'M';
      $sizeSleeve = 'M';
      $sizeHip = 'M';
      $lengthSideSeam = 'M';
      $sizeLength = 'M';
      $image = ['name' => 'image1.jpg', 'tmp_name' => '/tmp/phpYzdqkD'];

      $result = $this->addItemHandler->processAddItem($name, $description, $gender, $partType, $itemType, $sizeShoulder, $sizeChest, $sizeSleeve, $sizeHip, $lengthSideSeam, $sizeLength, $image);
      $this->assertEquals('Item added successfully.', $result);
   }

   public function testProcessAddItemFailureEmptyName()
   {
      $name = '';
      $description = 'Description1';
      $gender = 'Male';
      $partType = 'Upper';
      $itemType = 'Shirt';
      $sizeShoulder = 'M';
      $sizeChest = 'M';
      $sizeSleeve = 'M';
      $sizeHip = 'M';
      $lengthSideSeam = 'M';
      $sizeLength = 'M';
      $image = ['name' => 'image1.jpg', 'tmp_name' => '/tmp/phpYzdqkD'];

      $result = $this->addItemHandler->processAddItem($name, $description, $gender, $partType, $itemType, $sizeShoulder, $sizeChest, $sizeSleeve, $sizeHip, $lengthSideSeam, $sizeLength, $image);
      $this->assertEquals('Item name and description are required.', $result);
   }

   public function testProcessAddItemFailureUploadImage()
   {
      $name = 'Item1';
      $description = 'Description1';
      $gender = 'Male';
      $partType = 'Upper';
      $itemType = 'Shirt';
      $sizeShoulder = 'M';
      $sizeChest = 'M';
      $sizeSleeve = 'M';
      $sizeHip = 'M';
      $lengthSideSeam = 'M';
      $sizeLength = 'M';
      $image = ['name' => '']; // Пустое имя файла для имитации ошибки загрузки

      $result = $this->addItemHandler->processAddItem($name, $description, $gender, $partType, $itemType, $sizeShoulder, $sizeChest, $sizeSleeve, $sizeHip, $lengthSideSeam, $sizeLength, $image);
      $this->assertEquals('Failed to upload image.', $result);
   }
}
