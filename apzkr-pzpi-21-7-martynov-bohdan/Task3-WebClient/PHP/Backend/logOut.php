<?php
session_start();

// Уничтожение всех данных сессии
session_unset();
session_destroy();

// Удаление куки (если используется куки для аутентификации)
setcookie('user', '', time() - 3600, "/");

// Перенаправление пользователя на главную страницу
header('Location: ./index.php');
exit();
