<?php


if (!empty($_POST['email']) && !empty($_POST['apiKey'])) {
   $email = $_POST['email'];
   $apiKey = $_POST['apiKey'];
   $con = mysqli_connect("localhost", "root", "", "moda_test");
   if ($con) {
      $sql = "SELECT * FROM client WHERE email = '" . $email . "' AND apiKey = '" . $apiKey . "'";
      $res = mysqli_query($con, $sql);
      if (mysqli_num_rows($res) != 0) {
         $row = mysqli_fetch_assoc($res);
         $sqlUpdate = "UPDATE client SET apiKey = '' WHERE email = '" . $email . "'";
         if (mysqli_query($con, $sqlUpdate)) {
            echo "success";
         } else  echo "Logout failed";
      } else echo "Unauthorized access";
   } else echo "Database connection failed";
} else echo "All fields are required";
