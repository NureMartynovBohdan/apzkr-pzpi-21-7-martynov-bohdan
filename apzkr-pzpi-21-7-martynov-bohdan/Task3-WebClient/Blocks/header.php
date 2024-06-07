<?php require "./db.php";

require "./languages/language.php"


?>
<header class="navbar navbar-expand-lg navbar-light bg-light">
   <nav class="container">
      <a class="navbar-brand" href="../web/index.php">
         <img src="img/0.png" alt="Logo" width="60" height="60" class="d-inline-block align-text-top">
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false">
         <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse text-center" id="navbarContent">
         <ul class="nav nav-item nav-pills navbar-nav mx-auto">
            <li class="new-item me-2"><a href="../web/index.php" class="nav-link text-black"><?= $texts['home']; ?></a></li>
            <li class="new-item me-2"><a href="../web/addItemForm.php" class="nav-link text-black"><?= $texts['add_new_item']; ?></a></li>
            <li class="new-item me-2"><a href="../web/registerClientForm.php" class="nav-link text-black"><?= $texts['add_user']; ?></a></li>
            <li class="new-item me-2"><a href="../web/listClientForm.php" class="nav-link text-black"><?= $texts['list_users']; ?></a></li>
            <!-- <li class="new-item me-2"><a href="../web/index.php?chapter=science" class="nav-link text-black">-</a></li> -->
            <!-- <li class="new-item me-2"><a href="../web/index.php?chapter=science" class="nav-link text-black">-</a></li> -->
            <!-- Язык -->
         </ul>


         <form action="" method="post" class="form-inline">
            <select name="lang" onchange="this.form.submit()" class="form-select">
               <option value="ua" <?php echo ($currentLang == 'ua') ? 'selected' : ''; ?>>Українська</option>
               <option value="en" <?php echo ($currentLang == 'en') ? 'selected' : ''; ?>>English</option>
            </select>
         </form>

         <?php
         if (isset($_COOKIE['user'])) {
            // Куки установлены, показываем кнопку "Выйти" и приветствие
            $username = $_COOKIE['user'];
            // Получение имени пользователя из базы данных
            $sql = "SELECT user_name FROM users WHERE user_name = '$username'";
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            $user_name = $row['user_name'];
         ?>
            <div class="text-center ms-2">
               <?= $texts['welcome_message'] . $user_name; ?>!
               <a href="./logOut.php" class="btn btn-outline-primary ml-1"><?= $texts['logout']; ?></a>
            </div>
         <?php
         } else {
            // Куки не установлены, показываем кнопки "Войти" и "Регистрация"
         ?>
            <div class="text-center">
               <a href="./logInForm.php" class="btn btn-outline-primary ms-3"><?= $texts['login']; ?></a>
               <a href="./registerForm.php" class="btn btn-outline-primary ms-3"><?= $texts['register']; ?></a>
            </div>
         <?php
         }
         ?>
      </div>
   </nav>
</header>