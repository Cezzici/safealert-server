<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'authority') {
  header("Location: login.php");
  exit();
}

require_once 'db.php';

$form_id = $_POST['form_id'] ?? null;
$intervention_type = $_POST['intervention_type'] ?? '';
$responsible_person = $_POST['responsible_person'] ?? '';
$details = $_POST['details'] ?? '';
$status = $_POST['status'] ?? '';
$timestamp = date('Y-m-d H:i:s');

if (!$form_id || !$intervention_type || !$status) {
  echo "<script>alert('Toate câmpurile obligatorii trebuie completate.'); window.history.back();</script>";
  exit();
}

// Inserare în baza de date
$stmt = $conn->prepare("
  INSERT INTO interventions (form_id, intervention_type, responsible_person, details, status, timestamp)
  VALUES (?, ?, ?, ?, ?, ?)
");

$stmt->bind_param("isssss", $form_id, $intervention_type, $responsible_person, $details, $status, $timestamp);

if ($stmt->execute()) {
  echo "<script>alert('✅ Intervenția a fost salvată cu succes.'); window.location.href = 'form_view.php?id=$form_id';</script>";
} else {
  echo "<script>alert('❌ Eroare la salvarea intervenției: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
