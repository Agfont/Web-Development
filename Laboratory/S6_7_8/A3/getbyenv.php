<?php
if($_SERVER["REQUEST_METHOD"] != "GET"){
  header("Location: error_pages/405.html");
  exit("405 Method Not Allowed");
}

// Get the q parameter from URL 
$env = $_REQUEST["env"];

// Connection to MySQL
$servername = "localhost";
$username = "root";
$password = "";
// XML Object creation
$xmldoc = new DOMDocument('1.0', 'UTF-8');
try {
    $conn = new PDO("mysql:host=$servername;dbname=hoteles", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";

    $env = $conn->quote($env);
    $result = $conn->query("SELECT * FROM hoteles WHERE zona = $env LIMIT 3")->fetchAll();
    $num = count($result);

    // Create and add root element <hotels>
    $hotels = $xmldoc->createElement("hotels");
    $xmldoc->appendChild($hotels);

    if ($num != 0) {
      $i = 0;
      foreach ($result as $row) {
        // Check if website of each image is available
        $file_headers = get_headers($row["img"]);
        $img = $row["img"];
        $exists = false;
        if($file_headers && str_contains($file_headers[0], 'HTTP/1.1 200')) $exists = true;
        if (!$exists) $img = "imageNotFound.png";

        // Create <hotel> and append
        $hotel = $xmldoc->createElement("hotel", $i);
        $hotels->appendChild($hotel);

        // Replace special character & for &amp
        $nombre = str_replace("&", "&amp;", $row["nombre"]);

        // Create <hotel> children elements, values and attr
        $name = $xmldoc->createElement("name", $nombre);
        $city = $xmldoc->createElement("city", $row["ciudad"]);
        $country = $xmldoc->createElement("country", $row["pais"]);
        $zone = $xmldoc->createElement("zone", $row["zona"]);
        $pool = $xmldoc->createElement("pool", $row["piscina"]);
        $img_tag = $xmldoc->createElement("img");
        $img_tag->setAttribute("src", $img);

        // Append nodes
        $hotel->appendChild($name);
        $hotel->appendChild($city);
        $hotel->appendChild($country);
        $hotel->appendChild($zone);
        $hotel->appendChild($pool);
        $hotel->appendChild($img_tag);
        
        $i++;
      }
    } 
    // Save XML to server
    echo $xmldoc->saveXML();

} catch(PDOException $e) {
    // echo "Connection failed: " . $e->getMessage();
}
?>