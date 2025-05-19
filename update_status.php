<?php
// Activăm afișarea erorilor pentru debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Setăm header pentru răspuns JSON
header('Content-Type: application/json');

// Conectare la baza de date
require_once 'db.php';

// Verificăm metoda POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preluăm valorile din POST
    $id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $status = isset($_POST['status']) ? trim($_POST['status']) : null;

    // Validare simplă
    if ($id && $status) {
        // Escape pentru siguranță
        $status = $conn->real_escape_string($status);

        // Construim interogarea
        $sql = "UPDATE alerts SET status = '$status' WHERE id = $id";
        $result = $conn->query($sql);

        // Răspuns în funcție de rezultat
        if ($result) {
            if ($conn->affected_rows === 0) {
                echo json_encode(["success" => false, "message" => "Nicio modificare. ID inexistent sau status deja setat."]);
            } else {
                echo json_encode(["success" => true, "message" => "Status actualizat pentru alerta #$id"]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Eroare SQL: " . $conn->error]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Date lipsă: id sau status."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Metodă invalidă. Folosește POST."]);
}

// Închidem conexiunea
$conn->close();
?>
