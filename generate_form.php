<?php
include 'db.php';

function detectRegion($lat, $long) {
    if ($lat >= 44.3 && $lat <= 44.6 && $long >= 25.9 && $long <= 26.3) {
        return 'București';
    } elseif ($lat >= 44.2 && $lat <= 44.5 && $long >= 25.7 && $long <= 26.1) {
        return 'Ilfov';
    } elseif ($lat >= 46.7 && $lat <= 46.9 && $long >= 23.5 && $long <= 23.7) {
        return 'Cluj';
    } else {
        return 'Necunoscut';
    }
}

if (isset($_GET['alert_id'])) {
    $alert_id = (int)$_GET['alert_id'];

    // Preluăm alerta
    $alert_sql = "SELECT * FROM alerts WHERE alert_id = $alert_id";
    $alert_result = $conn->query($alert_sql);

    if ($alert_result->num_rows > 0) {
        $alert = $alert_result->fetch_assoc();

        $lat = $alert['latitude'];
        $long = $alert['longitude'];
        $severity = $alert['severity'];
        $user_id = $alert['user_id'];
        $authority_id = $alert['authority_id'];

        $region = detectRegion($lat, $long);

        // Caută autoritate activă în regiune dacă nu există în alertă
        if (empty($authority_id)) {
            $auth_query = "SELECT authority_id FROM authorities WHERE region = '$region' AND status = 'activ' LIMIT 1";
            $auth_result = $conn->query($auth_query);
            if ($auth_result && $auth_result->num_rows > 0) {
                $authority_id = $auth_result->fetch_assoc()['authority_id'];
            } else {
                $authority_id = null;
            }
        }

        // Construim detaliile
        $details = "Alertă generată automat de sistem pentru analiza cazului raportat de user ID: $user_id. ";
        $details .= "Regiune detectată: $region. ";
        $details .= $authority_id 
            ? "Autoritate desemnată automat: $authority_id." 
            : "NU s-a găsit autoritate disponibilă în zonă.";

        // Formatare locație
        $location = "Coord: $lat, $long";

        // Cod formular generat
        $code = 'SAF-' . date('Ymd') . '-' . rand(100, 999);

        // Inserăm în formular
        $insert_sql = "INSERT INTO forms (user_id, location, severity, details, created_at, alert_id, authority_id, status, code)
                       VALUES (?, ?, ?, ?, NOW(), ?, ?, 'new', ?)";
        $stmt = $conn->prepare($insert_sql);
        $severity_text = "Nivel $severity";
        $stmt->bind_param("isssiss", $user_id, $location, $severity_text, $details, $alert_id, $authority_id, $code);

        if ($stmt->execute()) {
            // Update status alertă
            $conn->query("UPDATE alerts SET status = 'in_progress' WHERE alert_id = $alert_id");
            echo "Formular generat cu succes!";
        } else {
            echo "Eroare la salvare formular: " . $conn->error;
        }

    } else {
        echo "Alerta nu a fost găsită.";
    }

} else {
    echo "ID alertă lipsă.";
}
?>
