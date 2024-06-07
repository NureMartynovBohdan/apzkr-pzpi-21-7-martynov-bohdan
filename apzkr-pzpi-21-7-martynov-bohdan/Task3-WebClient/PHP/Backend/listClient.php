<?php
require "./db.php";
function getClients($admin_id)
{
   global $conn;

   $clients = array();

   $sql = "SELECT * FROM client WHERE admin_id = ?";

   $stmt = $conn->prepare($sql);
   $stmt->bind_param("i", $admin_id);

   $stmt->execute();

   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
         $clients[] = $row;
      }
   }

   return $clients;
}
