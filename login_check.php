<?php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = trim($_POST['username']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, username, password_hash, role FROM users WHERE username = ?");
  $stmt->bind_param("s", $username);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password_hash'])) {
      // Autentificare reușită
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['username'] = $user['username'];
      $_SESSION['role'] = $user['role'];

      header("Location: dashboard.php");
      exit();
    }
  }

  // Autentificare eșuată
  header("Location: login.php?error=1");
  exit();
} else {
  // Acces direct nepermis
  header("Location: login.php");
  exit();
}
