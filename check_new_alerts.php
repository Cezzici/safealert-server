<?php
require_once 'db.php';

// Numar conturi pending
$resultPending = $conn->query("SELECT COUNT(*) AS count FROM pending_users");
$rowPending = $resultPending->fetch_assoc();
$pendingCount = $rowPending['count'];

// Numar alerte noi
$resultAlerts = $conn->query("SELECT COUNT(*) AS count FROM alerts WHERE status = 'new'");
$rowAlerts = $resultAlerts->fetch_assoc();
$alertsCount = $rowAlerts['count'];

// Returnam ambele numere ca JSON
echo json_encode([
    'pending' => $pendingCount,
    'alerts' => $alertsCount
]);
?>
