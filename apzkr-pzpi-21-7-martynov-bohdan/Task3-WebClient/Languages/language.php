<?php
// Перевіряємо, чи сесія вже стартована
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}

// Устанавлюємо мову за замовчуванням, якщо вона не встановлена
if (!isset($_SESSION['lang'])) {
   $_SESSION['lang'] = 'ua'; // Українська
}

// Обробка форми вибору мови
if (isset($_POST['lang'])) {
   $lang = $_POST['lang'];

   // Перевірка на допустимі мови
   $allowedLanguages = ['ua', 'en'];

   if (in_array($lang, $allowedLanguages)) {
      $_SESSION['lang'] = $lang;
   }
}

// Поточна обрана мова
$currentLang = $_SESSION['lang'];

// Підключаємо файл з текстами для поточної мови
$texts = include_once "./languages/$currentLang.php";
return $texts;
