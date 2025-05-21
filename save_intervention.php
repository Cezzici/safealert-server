<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Metodă invalidă.";
    exit();
}

$form_id = $_POST['form_id'] ?? null;
$intervention_id = $_POST['intervention_id'] ?? null;
$intervention_type = $_POST['intervention_type'] ?? '';
$responsible_person = $_POST['responsible_person'] ?? '';
$details = $_POST['details'] ?? '';
$status = $_POST['status'] ?? '';
$created_at = date('Y-m-d H:i:s');

// Validare minimă
if (!$form_id || empty($intervention_type) || empty($responsible_person) || empty($details)) {
    echo "Date lipsă.";
    exit();
}

if ($intervention_id) {
    // UPDATE
    $stmt = $conn->prepare("UPDATE interventions SET intervention_type = ?, responsible_person = ?, details = ?, status = ?, created_at = ? WHERE intervention_id = ?");
    $stmt->bind_param("sssssi", $intervention_type, $responsible_person, $details, $status, $created_at, $intervention_id);
} else {
    // INSERT
    $stmt = $conn->prepare("INSERT INTO interventions (form_id, intervention_type, responsible_person, details, status, created_at) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $form_id, $intervention_type, $responsible_person, $details, $status, $created_at);
}

if ($stmt->execute()) {
    header("Location: form_view.php?form_id=" . urlencode($form_id));
    exit();
} else {
    echo "Eroare la salvare.";
    exit();
}
