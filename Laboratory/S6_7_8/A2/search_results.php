<?php
    function check_dates($d1, $d2) {
        return (strtotime($d2) > strtotime($d1) && strtotime($d1) >= strtotime(date("Y/m/d")));
    }
    //echo '<div class="row destResults my-3 mx-1 p-2">';
    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // JSON decode PHP
            $json = json_decode($_POST["json"]);
            $dest = $json->destination;
            $checkin = $json->checkin;
            $checkout = $json->checkout;
            $guests = $json->guests;
            $regex_dest = "/^[a-zA-Zx{00C0}-\x{00FF} -]{1,20}$/"; // Max: 20 characters
            $regex_guests = "/^[1-9]$|^1[0-9]$|^20$/"; // Max: 100 guests
            
            if (!preg_match($regex_dest, $dest)) {
                throw new Exception('Destination field must contain 1 to 20 characters!');
            }
            elseif (!preg_match($regex_guests, $guests)) {
                throw new Exception('Guests number must be between 1 and 20!a');
            }
            elseif (!check_dates($checkin, $checkout)) {
                throw new Exception('Checkin date must be greater or equal than today!');
            }
                
        } else { 
            throw new Exception('Requested method was not a POST!');
        }
    } catch(Exception $e){
        $error = array('error' => $e->getMessage());
        echo json_encode($error);
        die();
    }
    // Connection to MySQL
    $servername = "localhost";
    $username = "root";
    $password = "";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=hoteles", $username, $password);
        // Set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully";
        // echo '<h5>Filters: ' .$checkin. '-' .$checkout. ' for ' .$guests. ' guests</h5>';
    } catch(PDOException $e) {
        $error = array();
        $error[] = array('error' => "Connection failed " .$e->getMessage());
        echo json_encode($error);
        die();
    }
    $results = array(); // Create an array to store JSON data
    $dest_quo = $conn->quote($dest);
    $rows = $conn->query("SELECT * FROM hoteles WHERE ciudad = $dest_quo");
    //echo '</div>';
    //echo '<h4>Houses in '.$dest.':</h4>';

    if ($rows->rowCount() > 0) {
        $i = 1;
        foreach ($rows as $row) {
            $piscina_str = '-';
            if ($row['piscina'] == 1) $piscina_str = 'Pool available';
            $results[] = array('name' => $row['nombre'], 'zone' => $row['zona'], 'city' => $row['ciudad'],
             'country' => $row['pais'], 'pool' => $piscina_str, 'img' => $row['img']);
            $i++;
        }
        // PHP JSON Encode
        echo json_encode($results);
    }
?>