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
   //addItemForm
   $user_id = $_SESSION['user_id'];
   $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      // Проверяем роль пользователя
      if ($user['role'] === 'admin') {
         // Пользователь с ролью "admin" имеет доступ к этой странице
         $admin_name = $user['user_name'];
      } elseif ($user['role'] === 'superadmin') {
         // Пользователь с ролью "superadmin" не имеет доступа, перенаправляем его на главную страницу
         header('Location: ./indexAdmin.php');
         exit();
      }
   } else {
      // Если не удалось получить информацию о пользователе, перенаправляем на страницу входа
      header('Location: ./logInForm.php');
      exit();
   }
   ?>

   <div class="container mt-5">
      <h2><?= $texts['add_new_item']; ?></h2>

      <!-- Форма для добавления новой вещи -->
      <form action="addItem.php" method="POST" enctype="multipart/form-data">
         <div class="mb-3">
            <label for="name" class="form-label"><?= $texts['item_name']; ?>:</label>
            <input type="text" class="form-control" id="name" name="name" required>
         </div>

         <div class="mb-3">
            <label for="description" class="form-label"><?= $texts['description']; ?>:</label>
            <input type="text" class="form-control" id="description" name="description" required>
         </div>

         <div class="mb-3">
            <label for="gender" class="form-label"><?= $texts['gender']; ?>:</label>
            <select class="form-select" id="gender" name="gender" required>
               <option value="Чоловік"><?= $texts['male']; ?></option>
               <option value="Жінка"><?= $texts['female']; ?></option>
            </select>
         </div>

         <div class="mb-3">
            <label for="part_type" class="form-label"><?= $texts['clothing_part']; ?>:</label>
            <select class="form-select" id="part_type" name="part_type" required>
               <option value="Верх"><?= $texts['upper']; ?></option>
               <option value="Низ"><?= $texts['lower']; ?></option>
            </select>
         </div>

         <div class="mb-3">
            <label for="item_type" class="form-label"><?= $texts['item_type']; ?>:</label>
            <select class="form-select" id="item_type" name="item_type" required>
               <option data-part-type="Верх" value="Рубашка" data-gender="Чоловік Жінка"><?= $texts['shirt']; ?></option>
               <option data-part-type="Верх" value="Футболка" data-gender="Чоловік Жінка"><?= $texts['t_shirt']; ?></option>
               <option data-part-type="Верх" value="Свитер" data-gender="Чоловік Жінка"><?= $texts['sweater']; ?></option>
               <option data-part-type="Верх" value="Платье" data-gender="Жінка"><?= $texts['dress']; ?></option>
               <option data-part-type="Низ" value="Юбка" data-gender="Жінка"><?= $texts['skirt']; ?></option>
               <option data-part-type="Низ" value="Брюки" data-gender="Чоловік Жінка"><?= $texts['trousers']; ?></option>
               <option data-part-type="Низ" value="Шорты" data-gender="Чоловік Жінка"><?= $texts['shorts']; ?></option>
               <option data-part-type="Низ" value="Капри" data-gender="Жінка"><?= $texts['capri']; ?></option>
            </select>
         </div>

         <!-- Верх -->

         <div class="mb-3 data-part-top" id="size_shoulder">
            <label for="size_shoulder" class="form-label"><?= $texts['shoulder_width']; ?>:</label>
            <input type="text" class="form-control" id="size_shoulder" name="size_shoulder">
         </div>

         <div class="mb-3 data-part-top" id="size_chest">
            <label for="size_chest" class="form-label"><?= $texts['chest_circumference']; ?>:</label>
            <input type="text" class="form-control" id="size_chest" name="size_chest">
         </div>

         <div class="mb-3 data-part-top" id="size_sleeve">
            <label for="size_sleeve" class="form-label"><?= $texts['sleeve_length']; ?>:</label>
            <input type="text" class="form-control" id="size_sleeve" name="size_sleeve">
         </div>

         <!-- Низ -->

         <div class="mb-3 data-part-down">
            <label for="size_hip" class="form-label"><?= $texts['hip_circumference']; ?>:</label>
            <input type="text" class="form-control" id="size_hip" name="size_hip">
         </div>

         <div class="mb-3 data-part-down">
            <label for="length_side_seam" class="form-label"><?= $texts['side_seam_length']; ?>:</label>
            <input type="text" class="form-control" id="length_side_seam" name="length_side_seam">
         </div>

         <!-- Общее -->

         <div class="mb-3">
            <label for="size_length" class="form-label"><?= $texts['item_length']; ?>:</label>
            <input type="text" class="form-control" id="size_length" name="size_length">
         </div>

         <!-- Изображение -->

         <div class="mb-3">
            <label for="image" class="form-label"><?= $texts['image']; ?>:</label>
            <input type="file" class="form-control" id="image" name="image">
         </div>

         <button type="submit" name="submit" class="btn btn-primary"><?= $texts['add_item']; ?></button>

         <!-- Сообщения об ошибках и успехе -->
         <label class="msg d-flex justify-content-center mx-4 mb-3 mb-lg-4" style="color:orangered">
            <?= isset($_SESSION['message_err_add_img']) ? $_SESSION['message_err_add_img'] : ''; ?>
            <?php unset($_SESSION['message_err_add_img']); ?>
         </label>

         <label class="msg d-flex justify-content-center mx-4 mb-3 mb-lg-4" style="color:green">
            <?= isset($_SESSION['message_add_db']) ? $_SESSION['message_add_db'] : ''; ?>
            <?php unset($_SESSION['message_add_db']); ?>
         </label>
      </form>
   </div>

   <?php
   $user_id = $_SESSION['user_id'];
   $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
   $result = $conn->query($sql);

   if ($result->num_rows > 0) {
      $user = $result->fetch_assoc();

      // Проверяем роль пользователя
      if ($user['role'] === 'admin') {
         // Пользователь с ролью "admin" имеет доступ к этой странице
         $admin_name = $user['user_name'];
      } elseif ($user['role'] === 'superadmin') {
         // Пользователь с ролью "superadmin" не имеет доступа, перенаправляем его на главную страницу
         header('Location: ./indexAdmin.php');
         exit();
      }
   } else {
      // Если не удалось получить информацию о пользователе, перенаправляем на страницу входа
      header('Location: ./logInForm.php');
      exit();
   }
   ?>


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