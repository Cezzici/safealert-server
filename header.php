<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8" />
  <title>SafeAlert</title>
  <link rel="icon" href="LOGO SAFEALERT.png" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f2f0f7;
      color: #333;
    }
    .navbar {
      background-color: #5e4283;
      color: white;
      padding: 10px 30px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .navbar .left {
      display: flex;
      align-items: center;
    }
    .navbar img {
      height: 36px;
      margin-right: 12px;
    }
    .navbar h1 {
      font-size: 20px;
      margin: 0;
    }
    .navbar .right {
      font-size: 14px;
    }
    .navbar .right strong {
      font-weight: 600;
    }
    .navbar a {
      color: white;
      text-decoration: none;
      font-weight: bold;
      margin-left: 15px;
    }
    .navbar a:hover {
      text-decoration: underline;
    }
    .main-content {
      padding: 40px;
      max-width: 1000px;
      margin: 0 auto;
    }
    .menu-button {
      background-color: #4CAF50;
      color: white;
      border: none;
      padding: 15px 32px;
      text-align: center;
      font-size: 16px;
      margin: 10px 2px;
      cursor: pointer;
      border-radius: 8px;
    }
    .menu-button:hover {
      background-color: #45a049;
    }
  </style>
</head>
<body>
  <div class="navbar">
    <div class="left">
      <img src="LOGO SAFEALERT.png" alt="SafeAlert Logo" />
      <h1>SafeAlert - Interfață Secure</h1>
    </div>
    <div class="right">
      Autentificat ca: <strong><?= htmlspecialchars($username) ?></strong> (<?= htmlspecialchars($role) ?>)
      <a href="logout.php">Logout</a>
    </div>
  </div>
  <div class="main-content">
