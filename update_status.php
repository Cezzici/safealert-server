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
    $alert_id = isset($_POST['id']) ? (int)$_POST['id'] : null;
    $status = isset($_POST['status']) ? trim($_POST['status']) : null;

    // Validare simplă
    if ($alert_id && $status) {
        // Pregătim interogarea pentru a evita SQL injection
        $stmt = $conn->prepare("UPDATE alerts SET status = ? WHERE alert_id = ?");
        if (!$stmt) {
            echo json_encode(["success" => false, "message" => "Eroare pregătire interogare: " . $conn->error]);
            exit();
        }

        $stmt->bind_param("si", $status, $alert_id);
        $stmt->execute();

        if ($stmt->affected_rows === 0) {
            echo json_encode(["success" => false, "message" => "Nicio modificare. ID inexistent sau status deja setat."]);
        } else {
            echo json_encode(["success" => true, "message" => "Status actualizat pentru alerta #$alert_id"]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Date lipsă: id sau status."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Metodă invalidă. Folosește POST."]);
}

// Închidem conexiunea
$conn->close();
?>
