<!DOCTYPE html>


<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>

<body>
   <?php require "blocks/header.php" ?>

   <div class="container mt-5">
      <h2><?= $texts['list_users']; ?></h2>

      <!-- Відображення списку клієнтів засобами PHP -->
      <?php
      require "./listClient.php";
      $user_id = $_SESSION['user_id']; // Отримання id адміністратора, який додає нового користувача      
      $clients = getClients($user_id);
      ?>

      <table class="table">
         <thead>
            <tr>
               <!-- <th scope="col">?= $texts['rfid']; ?></th> -->
               <th scope="col"><?= $texts['name']; ?></th>
               <th scope="col"><?= $texts['mail']; ?></th>
               <th scope="col"><?= $texts['id_admins']; ?></th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($clients as $client) : ?>
               <tr>
                  <!-- <td>?= $client['rfid'] ?></td> -->
                  <td><?= $client['name'] ?></td>
                  <td><?= $client['email'] ?></td>
                  <td><?= $client['admin_id'] ?></td>
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   </div>
   <?php require "./languages/language.php" ?>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>

</body>

</html>