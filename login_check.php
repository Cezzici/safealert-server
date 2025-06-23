<?php
session_start();
require_once 'db.php';
include 'header.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($username) || empty($password)) {
    header("Location: login.php?error=Completati toate campurile");
    exit();
}

// Se folosește numele real al coloanelor
$stmt = $conn->prepare("
    SELECT 
        system_user_id AS user_id, 
        username, 
        password_hash AS password, 
        role, 
        authority_id 
    FROM users 
    WHERE username = ?
");

if (!$stmt) {
    header("Location: login.php?error=Eroare baza de date");
    exit();
}

$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    header("Location: login.php?error=Utilizator inexistent");
    exit();
}

$user = $result->fetch_assoc();

if (!password_verify($password, $user['password'])) {
    header("Location: login.php?error=Parola incorecta");
    exit();
}

// LOGIN REUȘIT
$_SESSION['user_id'] = $user['user_id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];
$_SESSION['authority_id'] = $user['authority_id'];

header("Location: dashboard.php");
exit();
