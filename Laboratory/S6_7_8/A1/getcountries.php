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
    $result = $conn->query("SELECT DISTINCT pais FROM hoteles")->fetchAll();
    // lookup
    foreach ($result as $row) {
      $country = $row["pais"];
      $url = 'https://www.google.com/search?q='.urlencode($country);
        echo '<a href='.$url.' class="list-group-item">'.$country.'</a>';
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>