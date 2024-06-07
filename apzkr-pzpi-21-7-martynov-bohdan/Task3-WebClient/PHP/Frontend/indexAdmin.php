<!DOCTYPE html>
<html lang="uk">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<style>
   .a-p {
      text-decoration: none;
      color: black;
   }
</style>

<body>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

   <?php require "blocks/header.php" ?>
   <script src="js/index.js"></script>

   <div class="container">
      <h3 class="mx-auto my-5" style="width: 200px;"><?= $texts['fashion']; ?></h3>
      <div class="d-flex flex-wrap">
         <?php
         require "./db.php";

         try {

            if (!isset($_SESSION['user_id'])) {
               // Якщо користувач не аутентифікований, перенаправляємо його на сторінку входу
               header('Location: ./logInForm.php');
               exit();
            }

            // Отримуємо інформацію про поточного користувача з бази даних
            $user_id = $_SESSION['user_id'];
            $sql = "SELECT * FROM users WHERE user_id = '$user_id'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
               $user = $result->fetch_assoc();

               // Перевіряємо роль користувача
               if ($user['role'] === 'superadmin') {
                  // Користувач з роллю "superadmin" має доступ до цієї сторінки
                  $admin_name = $user['user_name'];
               } elseif ($user['role'] === 'admin') {
                  // Користувач з роллю "admin" не має доступу, перенаправляємо його на головну сторінку
                  header('Location: ./index.php');
                  exit();
               }
            } else {
               // Якщо не вдалося отримати інформацію про користувача, перенаправляємо на сторінку входу
               header('Location: ./logInForm.php');
               exit();
            }

            // Ваш SQL-запит
            $sql = "SELECT id, item_name, description, item_gender, item_part_type, item_type, item_size_shoulder, item_size_chest, item_size_sleeve, item_size_hip, item_length_side_seam, item_size_length, item_image, admin_id
                    FROM clothing_items";

            // Перевірка успішності виконання запиту
            $result = $conn->query($sql);

            // Перевірка успішності виконання запиту
            if ($result) {
               // Обхід результатів і виведення даних на сайті
               while ($row = $result->fetch_assoc()) {
                  $itemId = $row['id'];
                  $itemName = $row['item_name'];
                  $description = $row['description'];
                  $itemGender = $row['item_gender'];
                  $itemPartType = $row['item_part_type'];
                  $itemType = $row['item_type'];
                  $sizeShoulder = $row['item_size_shoulder'];
                  $sizeChest = $row['item_size_chest'];
                  $sizeSleeve = $row['item_size_sleeve'];
                  $sizeHip = $row['item_size_hip'];
                  $lengthSideSeam = $row['item_length_side_seam'];
                  $sizeLength = $row['item_size_length'];
                  $itemImage = $row['item_image'];
                  $idAdmins = $row['admin_id'];
         ?>
                  <div class="p-2 mb-3 card shadow-sm">
                     <a class="a-p" href="editForm.php?id=<?= $itemId; ?>">
                        <p class="card-text text-justify fs-5"><?= $texts['item_name']; ?>: <?= $itemName; ?></p>
                        <p class="card-text text-justify fs-5"><?= $texts['description']; ?>: <?= $description; ?></p>

                        <p class="card-text text-justify fs-5"><?= $texts['gender']; ?>: <?= $itemGender; ?></p>
                        <p class="card-text text-justify fs-5"><?= $texts['clothing_part']; ?>: <?= $itemPartType; ?></p>
                        <p class="card-text text-justify fs-5"><?= $texts['item_type']; ?>: <?= $itemType; ?></p>

                        <?php if ($sizeShoulder) : ?>
                           <p class="card-text text-justify fs-5"><?= $texts['shoulder_width']; ?>: <?= $sizeShoulder; ?></p>
                        <?php endif; ?>
                        <?php if ($sizeChest) : ?>
                           <p class="card-text text-justify fs-5"><?= $texts['chest_circumference']; ?>: <?= $sizeChest; ?></p>
                        <?php endif; ?>
                        <?php if ($sizeSleeve) : ?>
                           <p class="card-text text-justify fs-5"><?= $texts['sleeve_length']; ?>: <?= $sizeSleeve; ?></p>
                        <?php endif; ?>
                        <?php if ($sizeHip) : ?>
                           <p class="card-text text-justify fs-5"><?= $texts['hip_circumference']; ?>: <?= $sizeHip; ?></p>
                        <?php endif; ?>
                        <?php if ($lengthSideSeam) : ?>
                           <p class="card-text text-justify fs-5"><?= $texts['side_seam_length']; ?>: <?= $lengthSideSeam; ?></p>
                        <?php endif; ?>
                        <?php if ($sizeLength) : ?>
                           <p class="card-text text-justify fs-5"><?= $texts['item_length']; ?>: <?= $sizeLength; ?></p>
                        <?php endif; ?>
                        <?php if ($idAdmins) : ?>
                           <p class="card-text text-justify fs-5"><?= $texts['id_admins']; ?>: <?= $idAdmins; ?></p>
                        <?php endif; ?>
                        <?php if ($itemImage) : ?>
                           <p class="card-text text-justify fs-5"><img class="img-thumbnail" src="uploads/<?= $itemImage; ?>" alt="<?= $itemName; ?>"></p>
                        <?php endif; ?>
                     </a>
                  </div>
         <?php
               }
            } else {
               echo "Помилка виконання запиту: " . $conn->error;
            }

            // Закриття з'єднання з базою даних
            $conn->close();
         } catch (Exception $e) {
            echo "Помилка: " . $e->getMessage();
         }
         ?>
      </div>
   </div>
   <?php require "./languages/language.php" ?>
   <?php require "blocks/footer.php" ?>
</body>

</html>