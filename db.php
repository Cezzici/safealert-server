<?php
$host = "127.0.0.1";        
$port = "3306";            
$user = "root";             
$password = "";             
$database = "safealertbun";  

$conn = new mysqli($host, $user, $password, $database, $port);
mysqli_set_charset($conn, "utf8mb4");


if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>
