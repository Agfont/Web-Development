<!DOCTYPE html>
<html>
	<head>
	<link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<title>Nexthouse</title>
	</head>
<body>
    <nav class="navbar bg-primary justify-content-between text-white">
        <a href="cliente.html">
            <img src="next.png">
        </a>
        <h3>Welcome to Nexthouse, we hope you find yours!</h3>
        <a class="btn btn-outline-light" type="button" href="sign_up.html">Sign up</a>
    </nav>
	<div id="results_body" class="container-fluid">
        <div class="row destFinder my-3 mx-1 p-2">
            <?php
                function check_dates($d1, $d2) {
                    return (strtotime($d2) > strtotime($d1) && strtotime($d1) >= strtotime(date("Y/m/d")));
                }
                try {
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $dest = htmlspecialchars($_POST["destination"]);
                        $checkin = $_POST["checkin"];
                        $checkout = $_POST["checkout"];
                        $guests = $_POST["guests"];
                        $regex_dest = "/^[a-zA-Z -]{1,20}$/"; // Max: 20 characters
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
                $dest = $conn->quote($dest);
                $rows = $conn->query("SELECT * FROM hoteles WHERE ciudad = $dest");
            ?>
        </div>
            <h4>Houses in <?php echo $dest?>:</h4>
            <?php
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
        <div class="m-1">
            <h6>&#x00AE 2022 Nexthouse, Inc.</h6>
        </div>
    </div>
</body>
</html>
