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
	<div class="jumbotron-fluid text-center p-1 m-0 bg-info text-white">
	  <h2 class="font-weight-bold">Welcome to Nexthouse, we hope you find yours!</h2>
	</div>
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
                        throw new Exception('Method requested was not a POST!');
                    }
                } catch(Exception $e){
                    die('Message: '.$e->getMessage());
                }
            ?>
        <h5>Filters: <?php echo $checkin?>-<?php echo $checkout?> for <?php echo $guests?> guests</h5>
        </div>
            <h4>Houses in <?php echo $dest?>:</h4>
            <div class="list-group">
                <a class="list-group-item">Cozy house with great view to Parc Guell</a>
            </div>
        </div>
        <div class="m-1">
            <h6>© 2022 Nexthouse, Inc.</h6>
        </div>
    </div>
</body>
</html>
