<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "message" => "Metodă invalidă."]);
    exit();
}

// Preluare date din POST
$uuid = $_POST['user_id'] ?? '';
$display_name = $_POST['name'] ?? $uuid;
$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$severity = $_POST['severity'] ?? '';

// Validare date
if (empty($uuid) || !is_numeric($latitude) || !is_numeric($longitude) || !is_numeric($severity)) {
    echo json_encode(["success" => false, "message" => "Date lipsă sau invalide."]);
    exit();
}

$timestamp = date('Y-m-d H:i:s');
$status = 'new';

// Detectare locație și autoritate
$location = "Coord: $latitude, $longitude";
$authority_id = null;
$authority_name = 'Necunoscută';

$mapping = [
    'București' => ['lat_min' => 44.40, 'lat_max' => 44.45, 'long_min' => 26.09, 'long_max' => 26.12, 'name' => 'Sectia 1 de politie'],
    'Timișoara' => ['lat_min' => 45.74, 'lat_max' => 45.76, 'long_min' => 21.20, 'long_max' => 21.22, 'name' => 'Poliția Timișoara'],
    'Iași' => ['lat_min' => 47.15, 'lat_max' => 47.17, 'long_min' => 27.60, 'long_max' => 27.62, 'name' => 'Poliția Iași']
];

foreach ($mapping as $region => $coords) {
    if ($latitude >= $coords['lat_min'] && $latitude <= $coords['lat_max'] &&
        $longitude >= $coords['long_min'] && $longitude <= $coords['long_max']) {
        $location = $region;

        $stmtAuth = $conn->prepare("SELECT authority_id FROM authorities WHERE name = ? LIMIT 1");
        $stmtAuth->bind_param("s", $coords['name']);
        $stmtAuth->execute();
        $resAuth = $stmtAuth->get_result();
        if ($rowAuth = $resAuth->fetch_assoc()) {
            $authority_id = $rowAuth['authority_id'];
            $authority_name = $coords['name'];
        }
        $stmtAuth->close();
        break;
    }
}


$user_id_numeric = null;
$stmt = $conn->prepare("SELECT user_id, name FROM app_users WHERE uuid = ?");
$stmt->bind_param("s", $uuid);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $user_id_numeric = $row['user_id'];

    if (empty($row['name']) || $row['name'] !== $display_name) {
        $updateStmt = $conn->prepare("UPDATE app_users SET name = ? WHERE uuid = ?");
        $updateStmt->bind_param("ss", $display_name, $uuid);
        $updateStmt->execute();
        $updateStmt->close();
    }

} else {
    $insertUser = $conn->prepare("INSERT INTO app_users (uuid, name) VALUES (?, ?)");
    $insertUser->bind_param("ss", $uuid, $display_name);
    $insertUser->execute();
    $user_id_numeric = $insertUser->insert_id;
    $insertUser->close();
}
$stmt->close();

$stmtAlert = $conn->prepare("INSERT INTO alerts (user_id, latitude, longitude, severity, created_at, status, location, authority_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmtAlert->bind_param("sddissss", $uuid, $latitude, $longitude, $severity, $timestamp, $status, $location, $authority_id);
$stmtAlert->execute();
$alert_id = $stmtAlert->insert_id;
$stmtAlert->close();


$code = 'SAF-' . date('Ymd') . '-' . rand(100, 999);
$severity_text = "Nivel $severity";
$form_status = 'new';
$details = "Alertă generată automat de sistem pentru analiza cazului raportat de user ID: $display_name. Regiune detectată: $location. Autoritate desemnată automat: $authority_name.";

$formStmt = $conn->prepare("INSERT INTO forms (user_id, location, severity, details, created_at, alert_id, authority_id, status, code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$formStmt->bind_param("issssisss", $user_id_numeric, $location, $severity_text, $details, $timestamp, $alert_id, $authority_id, $form_status, $code);
$formStmt->execute();
$formStmt->close();


echo json_encode([
    "success" => true,
    "alert_id" => $alert_id,
    "location" => $location,
    "authority_id" => $authority_id,
    "form_code" => $code
]);
exit();
