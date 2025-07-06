<?php
require_once 'db.php';

$conn->query("UPDATE pending_users SET notified = 1 WHERE notified = 0");
$conn->query("UPDATE alerts SET status = 'read' WHERE status = 'new'");

header('Content-Type: application/json');
echo json_encode(['status' => 'success']);
exit();
?>
