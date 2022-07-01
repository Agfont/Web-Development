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
        <img src="next.png">
        <h3>Welcome to Nexthouse, we hope you find yours!</h3>
        <a class="btn btn-outline-light" type="button" href="sign_up.php">Sign up</a>
    </nav>
	<div class="container-fluid">
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
                        $regex_guests = "/^[1-9]{1,2}$/"; // Max: 100 guests
                        
                        if (!preg_match($regex_dest, $dest)) {
                            throw new Exception('Destination field must contain 1 to 20 characters!');
                        }
                        elseif (!preg_match($regex_guests, $guests)) {
                            throw new Exception('Guests number must be between 1 and 20!');
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
                    $conn = new PDO("mysql:host=$servername;dbname=world", $username, $password);
                    // Set the PDO error mode to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // echo "Connected successfully";
                    echo '<h5>Filters: ' .$checkin. '-' .$checkout. ' for ' .$guests. ' guests</h5>';
                } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                $dest = $conn->quote($dest);
                $rows = $conn->query("SELECT * FROM cities WHERE name = $dest");
            ?>
        </div>
            <h4>Houses in <?php echo $dest?>:</h4>
            <?php
                if ($rows->rowCount() > 0) {
                    echo '<table class="table table-hover">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Destination</th>
                                <th scope="col">District</th>
                                <th scope="col">Country</th>
                                <th scope="col">Population</th>
                                </tr>
                            </thead>
                            <tbody>';
                    $i = 1;
                    foreach ($rows as $row) {  
                        echo '<tr>
                                <th scope="row">'.$i.'</th>
                                <td>'.$row['name'].'</td>
                                <td>'.$row['district'].'</td>
                                <td>'.$row['country_code'].'</td>
                                <td>'.$row['population'].'</td>
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
            <h6>© 2022 Nexthouse, Inc.</h6>
        </div>
    </div>
</body>
</html>
