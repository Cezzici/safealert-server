<?php
// Setări conexiune
$host = "127.0.0.1";        // sau "localhost"
$port = "3306";             // dacă folosești portul 3307 în XAMPP
$user = "root";             // utilizatorul implicit
$password = "";             // de obicei e gol în XAMPP
$database = "safealert";    // numele bazei de date

// Conectare
$conn = new mysqli($host, $user, $password, $database, $port);
mysqli_set_charset($conn, "utf8mb4");

// Verificare conexiune
if ($conn->connect_error) {
    die("Conexiunea a eșuat: " . $conn->connect_error);
}

// Setare charset pentru caractere speciale
$conn->set_charset("utf8mb4");
?>
