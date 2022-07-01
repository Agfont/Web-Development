<?php
if($_SERVER["REQUEST_METHOD"] != "GET"){
  header("Location: error_pages/405.html");
  exit("405 Method Not Allowed");
}

// Get the q parameter from URL 
// $q = $_REQUEST["q"];

// Connection to MySQL
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=hoteles", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    // Query
    $result = $conn->query("SELECT DISTINCT zona FROM hoteles")->fetchAll();
    // lookup
    foreach ($result as $row) {
      $zona = $row["zona"];
      echo '<a href="#" class="list-group-item">'.$zona.'</a>';
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>