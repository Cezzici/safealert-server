<?php
session_start();
require_once 'db.php';

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT id, password_hash, role FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($user = $result->fetch_assoc()) {
    if (password_verify($password, $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['username'] = $username;

        // 🔁 Redirecționare pe baza rolului
        switch ($user['role']) {
            case 'admin':
                header("Location: dashboard.php");
                break;
            case 'authority':
                header("Location: view_alerts.php");
                break;
            case 'ngo':
                header("Location: view_forms.php");
                break;
            default:
                echo "Rol necunoscut.";
        }
        exit();
    } else {
        echo "Parolă incorectă.";
    }
} else {
    echo "Utilizator inexistent.";
}
?>
