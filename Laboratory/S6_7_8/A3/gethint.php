<?php
if($_SERVER["REQUEST_METHOD"] != "GET"){
  header("Location: error_pages/405.html");
  exit("405 Method Not Allowed");
}

// Get the q parameter from URL
$q = $_REQUEST["term"];

// Connection to MySQL
$servername = "localhost";
$username = "root";
$password = "";
$xmldoc = new DOMDocument('1.0', 'UTF-8');

try {
    $conn = new PDO("mysql:host=$servername;dbname=world", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";

    $result = $conn->query("SELECT name FROM cities")->fetchAll();
    // lookup all hints from array if $q is different from ""
    $dest = $xmldoc->createElement("destinations");
    $xmldoc->appendChild($dest);

    if ($q !== "") {
        $q = strtolower($q);
        $len = strlen($q);
        foreach ($result as $row) {
            $name = strtolower($row["name"]);
            if (stristr($q, substr($name, 0, $len))) { // stristr() searches for the first occurrence of a string inside another string
                $node = $xmldoc->createElement("name", ucfirst($name));
                $dest->appendChild($node);
            }
        }
    }
    // Save XML to server
    echo $xmldoc->saveXML();
} catch(PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
}
?>