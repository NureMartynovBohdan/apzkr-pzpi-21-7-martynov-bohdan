<!-- editForm.php -->

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>

   <?php require "blocks/header.php" ?>

   <?php
   // Подключение к базе данных
   require "./db.php";

   // Проверка, был ли передан идентификатор записи для редактирования
   if (isset($_GET['id'])) {
      $item_id = $_GET['id'];

      // Получение данных о вещи из базы данных
      $sql = "SELECT * FROM clothing_items WHERE id = $item_id";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
         $item = $result->fetch_assoc();
      } else {
         echo "Вещь не найдена";
         exit;
      }
   } else {
      echo "Идентификатор вещи не указан";
      exit;
   }
   ?>

   <div class="container mt-5">
      <h2><?= $texts['edit_item']; ?></h2>

      <input type="hidden" name="id" value="<?= $itemId ?>">
      <input type="hidden" name="id" value="<?= $item_id ?>">

      <!-- Форма для редактирования вещи -->
      <form action="update.php" method="POST" enctype="multipart/form-data">
         <input type="hidden" name="id" value="<?= $item_id ?>">
         <div class="mb-3">
            <label for="name" class="form-label"><?= $texts['item_name']; ?>:</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= $item['item_name']; ?>" required>
         </div>

         <div class="mb-3">
            <label for="description" class="form-label"><?= $texts['description']; ?>:</label>
            <input type="text" class="form-control" id="description" name="description" value="<?= $item['description']; ?>" required>
         </div>

         <div class="mb-3">
            <label for="gender" class="form-label"><?= $texts['gender']; ?>:</label>
            <select class="form-select" id="gender" name="gender" required>
               <option value="Чоловік" <?= ($item['item_gender'] == 'Чоловік') ? 'selected' : ''; ?>><?= $texts['male']; ?></option>
               <option value="Жінка" <?= ($item['item_gender'] == 'Жінка') ? 'selected' : ''; ?>><?= $texts['female']; ?></option>
            </select>
         </div>

         <div class="mb-3">
            <label for="part_type" class="form-label"><?= $texts['clothing_part']; ?>:</label>
            <select class="form-select" id="part_type" name="part_type" required>
               <option value="Верх" <?= ($item['item_part_type'] == 'Верх') ? 'selected' : ''; ?>><?= $texts['upper']; ?></option>
               <option value="Низ" <?= ($item['item_part_type'] == 'Низ') ? 'selected' : ''; ?>><?= $texts['lower']; ?></option>
            </select>
         </div>

         <div class="mb-3">
            <label for="item_type" class="form-label"><?= $texts['item_type']; ?>:</label>
            <select class="form-select" id="item_type" name="item_type" required>
               <option data-part-type="Верх" value="Рубашка" data-gender="Чоловік Жінка" <?= ($item['item_type'] == 'Рубашка') ? 'selected' : ''; ?>><?= $texts['shirt']; ?></option>
               <option data-part-type="Верх" value="Футболка" data-gender="Чоловік Жінка" <?= ($item['item_type'] == 'Футболка') ? 'selected' : ''; ?>><?= $texts['t_shirt']; ?></option>
               <option data-part-type="Верх" value="Свитер" data-gender="Чоловік Жінка" <?= ($item['item_type'] == 'Свитер') ? 'selected' : ''; ?>><?= $texts['sweater']; ?></option>
               <option data-part-type="Верх" value="Платье" data-gender="Жінка" <?= ($item['item_type'] == 'Платье') ? 'selected' : ''; ?>><?= $texts['dress']; ?></option>
               <option data-part-type="Низ" value="Юбка" data-gender="Жінка" <?= ($item['item_type'] == 'Юбка') ? 'selected' : ''; ?>><?= $texts['skirt']; ?></option>
               <option data-part-type="Низ" value="Брюки" data-gender="Чоловік Жінка" <?= ($item['item_type'] == 'Брюки') ? 'selected' : ''; ?>><?= $texts['trousers']; ?></option>
               <option data-part-type="Низ" value="Шорты" data-gender="Чоловік Жінка" <?= ($item['item_type'] == 'Шорты') ? 'selected' : ''; ?>><?= $texts['shorts']; ?></option>
               <option data-part-type="Низ" value="Капри" data-gender="Жінка" <?= ($item['item_type'] == 'Капри') ? 'selected' : ''; ?>><?= $texts['capri']; ?></option>
            </select>
         </div>

         <!-- Верх -->

         <div class="mb-3 data-part-top" id="size_shoulder">
            <label for="size_shoulder" class="form-label"><?= $texts['shoulder_width']; ?>:</label>
            <input type="text" class="form-control" id="size_shoulder" name="size_shoulder" value="<?= $item['item_size_shoulder']; ?>">
         </div>

         <div class="mb-3 data-part-top" id="size_chest">
            <label for="size_chest" class="form-label"><?= $texts['chest_circumference']; ?>:</label>
            <input type="text" class="form-control" id="size_chest" name="size_chest" value="<?= $item['item_size_chest']; ?>">
         </div>

         <div class="mb-3 data-part-top" id="size_sleeve">
            <label for="size_sleeve" class="form-label"><?= $texts['sleeve_length']; ?>:</label>
            <input type="text" class="form-control" id="size_sleeve" name="size_sleeve" value="<?= $item['item_size_sleeve']; ?>">
         </div>

         <!-- Низ -->

         <div class="mb-3 data-part-down">
            <label for="size_hip" class="form-label"><?= $texts['hip_circumference']; ?>:</label>
            <input type="text" class="form-control" id="size_hip" name="size_hip" value="<?= $item['item_size_hip']; ?>">
         </div>

         <div class="mb-3 data-part-down">
            <label for="length_side_seam" class="form-label"><?= $texts['side_seam_length']; ?>:</label>
            <input type="text" class="form-control" id="length_side_seam" name="length_side_seam" value="<?= $item['item_length_side_seam']; ?>">
         </div>

         <!-- Общее -->

         <div class="mb-3">
            <label for="size_length" class="form-label"><?= $texts['item_length']; ?>:</label>
            <input type="text" class="form-control" id="size_length" name="size_length" value="<?= $item['item_size_length']; ?>">
         </div>

         <!-- Изображение -->
         <div class="mb-3" style="text-align: center;">
            <img src="uploads/<?= $item['item_image']; ?>" alt="Current Image" class="img-thumbnail" style="max-width: 300px; width: 100%; height: auto; display: block; margin: 0 auto;">
            <label for="image" class="form-label" style="margin-top: 10px;"><?= $texts['edit_image']; ?>:</label>
            <input type="file" class="form-control" id="image" name="image">
         </div>

         <!-- Кнопка для редактирования записи -->
         <button type="submit" name="submit" class="btn btn-primary"><?= $texts['save']; ?></button>
         <!-- Кнопка для удаления записи -->
         <a href="delete.php?id=<?= $item['id']; ?>" class="btn btn-danger" onclick="return confirm('Вы уверены, что хотите удалить этот элемент?')"><?= $texts['delete']; ?></a>

      </form>
   </div>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

   <script>
      // Функция, которая будет вызываться при изменении выбора пола или части одежды
      function updateItemTypeOptions() {
         // Получаем выбранный пол
         var selectedGender = document.getElementById('gender').value;

         // Получаем выбранную часть одежды
         var selectedPartType = document.getElementById('part_type').value;

         // Получаем список опций в поле "Тип вещи"
         var itemTypeSelect = document.getElementById('item_type');
         var options = itemTypeSelect.options;

         // Проходимся по всем опциям и устанавливаем или снимаем атрибут disabled
         for (var i = 0; i < options.length; i++) {
            var option = options[i];
            var genderData = option.getAttribute('data-gender');
            var partTypeData = option.getAttribute('data-part-type');

            // Если опция не соответствует выбранному полу или части одежды, скрываем ее
            if (
               (genderData && genderData.indexOf(selectedGender) === -1) ||
               (partTypeData && partTypeData !== selectedPartType)
            ) {
               option.style.display = 'none';
            } else {
               option.style.display = '';
            }
         }

         // Обновляем дополнительные поля в зависимости от выбранной части одежды
         updateAdditionalFields();
      }

      // Функция для отображения или скрытия дополнительных полей в зависимости от выбранной части одежды
      function updateAdditionalFields() {
         // Получаем выбранную часть одежды
         var selectedPartType = document.getElementById('part_type').value;

         // Получаем элементы дополнительных полей
         var sizeShoulder = document.getElementById('size_shoulder');
         var sizeChest = document.getElementById('size_chest');
         var sizeSleeve = document.getElementById('size_sleeve');

         // Если выбрана часть одежды "Низ", скрываем соответствующие поля
         if (selectedPartType === 'Низ') {
            sizeShoulder.style.display = 'none';
            sizeChest.style.display = 'none';
            sizeSleeve.style.display = 'none';
         } else {
            // В противном случае, отображаем поля
            sizeShoulder.style.display = '';
            sizeChest.style.display = '';
            sizeSleeve.style.display = '';
         }

         // Получаем элементы дополнительных полей для верхней и нижней части
         var additionalFieldsTop = document.getElementsByClassName('data-part-top');
         var additionalFieldsBottom = document.getElementsByClassName('data-part-down');

         // Скрываем все дополнительные поля
         for (var i = 0; i < additionalFieldsTop.length; i++) {
            additionalFieldsTop[i].style.display = 'none';
         }

         for (var i = 0; i < additionalFieldsBottom.length; i++) {
            additionalFieldsBottom[i].style.display = 'none';
         }

         // Отображаем дополнительные поля в зависимости от выбранной части одежды
         if (selectedPartType === 'Верх') {
            for (var i = 0; i < additionalFieldsTop.length; i++) {
               additionalFieldsTop[i].style.display = '';
            }
         } else if (selectedPartType === 'Низ') {
            for (var i = 0; i < additionalFieldsBottom.length; i++) {
               additionalFieldsBottom[i].style.display = '';
            }
         }
      }

      // Добавляем обработчики событий для изменения выбора пола и части одежды
      document.getElementById('gender').addEventListener('change', updateItemTypeOptions);
      document.getElementById('part_type').addEventListener('change', updateItemTypeOptions);

      // Вызываем функцию при загрузке страницы, чтобы скрыть неподходящие опции и дополнительные поля
      updateItemTypeOptions();
   </script>


   <?php require "./languages/language.php" ?>
</body>

</html>