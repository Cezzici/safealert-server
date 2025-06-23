<?php
session_start();
require_once 'db.php';
include 'header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Actualizăm notificările necitite ca fiind citite
$conn->query("UPDATE notifications SET is_read = 1 WHERE is_read = 0");

// Revenim la dashboard
header("Location: dashboard.php");
exit();
