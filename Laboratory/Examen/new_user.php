<?php
    try {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = $_POST["name"];
            $email = htmlspecialchars($_POST["email"]);
            //$regex_email = "/[a-zA-Z]@[a-zA-Z].[a-zA-Z]{3}/";
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
        $conn = new PDO("mysql:host=$servername;dbname=simpsons", $username, $password);
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
    $pwd = rand(1,999);
    $result1 = $conn->query("SELECT * FROM students WHERE name = $name_quo")->fetchAll();
    $num = count($result1);
    if ($num != 0) {
        echo "Usuario $name registrado!";
    }
    else {
        $rows = $conn->query("INSERT INTO students (id, name, email, password) VALUES ($id, $name_quo, $email, $pwd)");
        echo "Usuario $name no registrado!";
        // echo 'User added sucessfully';
    }
?>
