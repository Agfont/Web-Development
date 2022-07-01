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
        <a class="btn btn-outline-light" type="button" href="sign_up.php">Sign up</a>
    </nav>
	<div class="container-fluid">
        <div class="row destFinder my-3 mx-1 p-2">
            <?php
                try {
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        $name = htmlspecialchars($_POST["name"]);
                        $email = $_POST["email"];
                        $pwd = $_POST["password"];
                        $regex_name = "/^[a-zA-Z -]{1,20}$/"; // Max: 20 characters
                        $regex_email = "/[-0-9a-zA-Z.+_]+@[-0-9a-zA-Z.+_]+.[a-zA-Z]{2,4}/";
                        
                        if (!preg_match($regex_name, $name)) {
                            throw new Exception('Name was incorrectly fullfilled!');
                        } elseif (!preg_match($regex_email, $email)) {
                            throw new Exception('Email was incorrectly fullfilled!');
                        } elseif (!strlen($pwd) > 5) {
                            throw new Exception('Password must contain at least 5 characters!');
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
                } catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
                // Insert new user
                $id = rand(1,999);
                $name_quo = $conn->quote($name);
                $email = $conn->quote($email);
                $pwd = $conn->quote($pwd);
                $rows = $conn->query("INSERT INTO users (id, name, email, password)
                VALUES ($id, $name_quo, $email, $pwd)");
                echo "Welcome to Nexthouse $name !";
                // echo 'User added sucessfully';
            ?>
        </div>
        <div class="m-1">
            <h6>&#x00AE 2022 Nexthouse, Inc.</h6>
        </div>
    </div>
</body>
</html>
