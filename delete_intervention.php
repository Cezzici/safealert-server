<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: dashboard.php");
  exit();
}

$intervention_id = (int)$_GET['id'];

// Preluăm form_id pentru redirect
$stmt = $conn->prepare("SELECT form_id FROM interventions WHERE intervention_id = ?");
$stmt->bind_param("i", $intervention_id);
$stmt->execute();
$res = $stmt->get_result();

if ($res->num_rows > 0) {
  $form = $res->fetch_assoc();
  $form_id = $form['form_id'];

  // 🔥 Ștergem efectiv intervenția
  $delete = $conn->prepare("DELETE FROM interventions WHERE intervention_id = ?");
  $delete->bind_param("i", $intervention_id);
  $delete->execute();

  header("Location: intervention_view.php?form_id=$form_id");
  exit();
}

header("Location: dashboard.php");
exit();
