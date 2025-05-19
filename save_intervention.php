<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'authority') {
  header("Location: login.php");
  exit();
}

require_once 'db.php';

$form_id = $_POST['form_id'] ?? null;
$intervention_type = trim($_POST['intervention_type'] ?? '');
$responsible_person = trim($_POST['responsible_person'] ?? '');
$details = trim($_POST['details'] ?? '');
$status = trim($_POST['status'] ?? '');
$timestamp = date('Y-m-d H:i:s');

if (!is_numeric($form_id) || !$intervention_type || !$status) {
  echo "<script>alert('⚠️ Toate câmpurile obligatorii trebuie completate.'); window.history.back();</script>";
  exit();
}

$stmt = $conn->prepare("
  INSERT INTO interventions (form_id, intervention_type, responsible_person, details, status, timestamp)
  VALUES (?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
  echo "<script>alert('❌ Eroare la pregătirea interogării SQL: " . $conn->error . "'); window.history.back();</script>";
  exit();
}

// fix: folosim variabile intermediare
$type = $intervention_type;
$person = $responsible_person;
$info = $details;
$stat = $status;
$time = $timestamp;

$stmt->bind_param("isssss", $form_id, $type, $person, $info, $stat, $time);

if ($stmt->execute()) {
  echo "<script>alert('✅ Intervenția a fost salvată cu succes.'); window.location.href = 'form_view.php?id=$form_id';</script>";
} else {
  echo "<script>alert('❌ Eroare la salvarea intervenției: " . $stmt->error . "'); window.history.back();</script>";
}

$stmt->close();
$conn->close();
