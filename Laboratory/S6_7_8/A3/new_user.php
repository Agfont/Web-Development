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
