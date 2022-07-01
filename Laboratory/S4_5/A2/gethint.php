<?php
if($_SERVER["REQUEST_METHOD"] != "POST"){
  header("Location: error_pages/405.html");
  exit("405 Method Not Allowed");
}

// Get the q parameter from URL
$q = $_REQUEST["q"];

// Connection to MySQL
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=world", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
    // Query
    $result = $conn->query("SELECT name FROM cities")->fetchAll();
    echo '<datalist id="destlist">';
    // lookup all hints from array if $q is different from ""
    if ($q !== "") {
        $q = strtolower($q);
        $len = strlen($q);
        foreach ($result as $row) {
            $name = strtolower($row["name"]);
            if (stristr($q, substr($name, 0, $len))) { // stristr() searches for the first occurrence of a string inside another string
                $hint = $name;
                echo '<option value='.
                      ucfirst($hint).'></option>';
            }
        }
    }
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>