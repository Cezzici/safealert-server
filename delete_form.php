<?php
session_start();
require_once 'db.php';
include 'header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
  header("Location: view_all_forms.php");
  exit();
}

$form_id = (int)$_GET['id'];


$conn->query("DELETE FROM interventions WHERE form_id = $form_id");


$conn->query("DELETE FROM forms WHERE form_id = $form_id");

header("Location: view_all_forms.php");
exit();
