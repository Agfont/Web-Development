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

try {
    $conn = new PDO("mysql:host=$servername;dbname=hoteles", $username, $password);
    // Set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";

    $env = $conn->quote($env);
    $result = $conn->query("SELECT * FROM hoteles WHERE zona = $env LIMIT 3")->fetchAll();
    $num = count($result);

    if ($num != 0) {
      echo '<h4 id="center_header"> Environment '.$result[0]['zona'].'</h4>';
      $num = 12 / $num;
      echo '<div id="cards_row" style="display:none;" class="row ui-corner-all">';
      foreach ($result as $row) {
        // Check if website of each image is available
        $file_headers = get_headers($row["img"]);
        $img = $row["img"];
        $exists = false;
        if($file_headers && str_contains($file_headers[0], 'HTTP/1.1 200')) $exists = true;
        if (!$exists) $img = "imageNotFound.png";
        
        // Draw each card
        echo '<div class="col-sm-'.$num.'">
                <div class="card">
                  <img src='.$img.' class="card-img-top">
                  <div class="card-body">
                    <h5 class="card-title">'.$row["nombre"].'</h5>
                    <p class="card-text">'.$row["ciudad"].', '.$row['pais'].'</p>
                    <a href="#" class="btn btn-primary">Reserve</a>
                  </div>
                </div>
              </div>';
      }
      echo '</div>';
    } else {
      echo '<h4 id="center_header"> No places were found!</h4>';
    }    
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>