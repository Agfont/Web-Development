<?php
    echo '<div class="row destResults my-3 mx-1 p-2">';   
    function check_dates($d1, $d2) {
        return (strtotime($d2) > strtotime($d1) && strtotime($d1) >= strtotime(date("Y/m/d")));
    }
    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $dest = htmlspecialchars($_POST["destination"]);
            $checkin = $_POST["checkin"];
            $checkout = $_POST["checkout"];
            $guests = $_POST["guests"];
            $regex_dest = "/^[a-zA-Z\x{00C0}-\x{00FF} -]{1,20}$/"; // Max: 20 characters
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
        die('Message: '.$e->getMessage());
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
        echo '<h5>Filters: ' .$checkin. '-' .$checkout. ' for ' .$guests. ' guests</h5>';
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    $dest_quo = $conn->quote($dest);
    $rows = $conn->query("SELECT * FROM hoteles WHERE ciudad = $dest_quo");
    echo '</div>';
    echo '<h4>Houses in '.$dest.':</h4>';

    if ($rows->rowCount() > 0) {
        echo '<table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Zone</th>
                    <th scope="col">City (Country)</th>
                    <th scope="col">Pool</th>
                    <th scope="col">Image</th>
                    </tr>
                </thead>
                <tbody>';
        $i = 1;
        foreach ($rows as $row) {
            $piscina_str = '-';
            if ($row['piscina'] == 1) $piscina_str = 'Pool available';
            echo '<tr>
                    <th scope="row">'.$i.'</th>
                    <td>'.$row['nombre'].'</td>
                    <td>'.$row['zona'].'</td>
                    <td>'.$row['ciudad'].', '.$row['pais'].'</td>
                    <td>'.$piscina_str.'</td>
                    <td><img class="img-thumbnail" 
                            style="width:200px; height:200px;" src='.$row['img'].'></td>
                </tr>';
            $i++;
        }
        echo '</tbody>
        </table>' ;
    } else {
        echo 'No houses were found. Please, try another destination!';
    }
?>