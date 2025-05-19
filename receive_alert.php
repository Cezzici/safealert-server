<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
require_once 'db.php';

// Loguri pentru debugging complet
file_put_contents("debug_alert.log", json_encode($_POST, JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
file_put_contents("debug_alert_raw.log", file_get_contents("php://input") . "\n", FILE_APPEND);

// Verifică dacă cererea este POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_POST)) {
        echo json_encode(["success" => false, "message" => "POST gol – verifică formatul cererii."]);
        exit;
    }

    $user_id = $_POST['user_id'] ?? '';
    $severity = $_POST['severity'] ?? '';
    $timestamp = date('Y-m-d H:i:s');
    $status = 'new';

    // DEFINIREA REGIUNILOR + COORDONATE (simulare completă)
    $regiuni = [
        "București" => ["Poliția Sector 1", "Poliția Sector 2", "Poliția Sector 3"],
        "Cluj" => ["Poliția Cluj-Napoca", "Jandarmeria Cluj"],
        "Iași" => ["Poliția Iași", "Jandarmeria Iași"],
        "Timișoara" => ["Poliția Timișoara", "Jandarmeria Timiș"],
        "Brașov" => ["Poliția Brașov", "Jandarmeria Brașov"]
    ];
    $coordonate_gps = [
        "București" => [44.4268, 26.1025],
        "Cluj" => [46.7712, 23.6236],
        "Iași" => [47.1585, 27.6014],
        "Timișoara" => [45.7489, 21.2087],
        "Brașov" => [45.6579, 25.6012]
    ];

    $localitati = array_keys($regiuni);
    $localitate = $localitati[array_rand($localitati)];
    $autoritate = $regiuni[$localitate][array_rand($regiuni[$localitate])];
    $latitude = $coordonate_gps[$localitate][0];
    $longitude = $coordonate_gps[$localitate][1];

    $severity = (int)$severity;

    if ($user_id && is_numeric($severity)) {
        $stmt = $conn->prepare("INSERT INTO alerts (user_id, latitude, longitude, severity, timestamp, status, location, authority) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sddissss", $user_id, $latitude, $longitude, $severity, $timestamp, $status, $localitate, $autoritate);

        if ($stmt->execute()) {
            $alert_id = $stmt->insert_id;

            // Cod unic pentru formular
            $nr = rand(100, 999);
            $code = "SAF-" . date('Ymd') . "-" . $nr;

            $stmt_form = $conn->prepare("
              INSERT INTO forms (user_id, alert_id, timestamp, location, severity, status, autoritate, code)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt_form->bind_param("iississs", $user_id, $alert_id, $timestamp, $localitate, $severity, $status, $autoritate, $code);
            $stmt_form->execute();
            $stmt_form->close();

            echo json_encode(["success" => true, "message" => "Alertă și formular salvate."]);
        } else {
            echo json_encode(["success" => false, "message" => "Eroare la salvarea alertei: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Date lipsă sau invalide."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Metodă invalidă."]);
}
$conn->close();
