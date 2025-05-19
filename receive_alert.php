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

$user_id = $_POST['user_id'] ?? '';
$latitude = $_POST['latitude'] ?? '';
$longitude = $_POST['longitude'] ?? '';
$severity = $_POST['severity'] ?? '';

if (!$user_id || !is_numeric($latitude) || !is_numeric($longitude) || !is_numeric($severity)) {
  echo json_encode(["success" => false, "message" => "Date lipsă sau invalide."]);
  exit();
}

$timestamp = date('Y-m-d H:i:s');
$status = 'new';

// Estimare locație și autoritate simplificată
$location = "Coord: $latitude, $longitude";
$autoritate = 'Necunoscută';

if ($latitude > 44.3 && $latitude < 44.6 && $longitude > 25.9 && $longitude < 26.3) {
  $location = "București";
  $autoritate = "Sectia 1 de politie";
} elseif ($latitude > 45.7 && $latitude < 45.8 && $longitude > 21.1 && $longitude < 21.3) {
  $location = "Timișoara";
  $autoritate = "Poliția Timișoara";
} elseif ($latitude > 47.0 && $latitude < 47.2 && $longitude > 27.5 && $longitude < 27.7) {
  $location = "Iași";
  $autoritate = "Poliția Iași";
}

// Inserare alertă
$stmt = $conn->prepare("INSERT INTO alerts (user_id, latitude, longitude, severity, timestamp, status, location, authority)
VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sddissss", $user_id, $latitude, $longitude, $severity, $timestamp, $status, $location, $autoritate);
$stmt->execute();
$alert_id = $conn->insert_id;

// Pregătim formularul asociat
$code = 'SAF-' . date('Ymd') . '-' . rand(100, 999);
$severity_text = "Nivel $severity";
$form_status = 'new';
$details = "Alertă generată automat de sistem pentru analiza cazului raportat de user ID: $user_id. Regiune detectată: $location. Autoritate desemnată automat: $autoritate.";
$zero = 0;

// Inserare formular
$formStmt = $conn->prepare("INSERT INTO forms (user_id, location, severity, details, timestamp, alert_id, autoritate, status, code)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$formStmt->bind_param("issssisss", $zero, $location, $severity_text, $details, $timestamp, $alert_id, $autoritate, $form_status, $code);
$formStmt->execute();

// Răspuns către aplicație
echo json_encode([
  "success" => true,
  "alert_id" => $alert_id,
  "location" => $location,
  "autoritate" => $autoritate,
  "form_code" => $code
]);
exit();
