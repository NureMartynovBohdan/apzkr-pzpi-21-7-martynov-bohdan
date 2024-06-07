<?php

function getDbConnection()
{
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "test";

   $conn = new mysqli($servername, $username, $password, $dbname);
   return $conn;
}
