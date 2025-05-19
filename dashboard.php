<?php
require_once 'header.php'; // include sesiune, navbar și stil global

// Titlu dashboard în funcție de rol
if ($role === 'admin') {
  $dashboardTitle = "Panou Administrator";
} elseif ($role === 'autoritate') {
  $dashboardTitle = "Panou Autoritate";
} elseif ($role === 'asistent') {
  $dashboardTitle = "Panou Asistență";
} else {
  $dashboardTitle = "Panou General SafeAlert";
}
?>

<div class="card">
  <h2><?= $dashboardTitle ?></h2>
  <p>Bun venit, <strong><?= htmlspecialchars($username) ?></strong>! Selectează o secțiune pentru a continua.</p>
</div>

<div class="card">
  <h3>🔍 Accese rapide</h3>
  <ul style="list-style: none; padding-left: 0;">
    <li><a href="view_alerts.php">📨 Alerte primite</a></li>
    <li><a href="view_all_forms.php">📝 Formulare completate</a></li>
    <li><a href="view_interventions.php">🚑 Intervenții înregistrate</a></li>
    <li><a href="view_authorities.php">🏢 Autorități disponibile</a></li>
  </ul>
</div>

<div class="card">
  <h3>ℹ️ Informații utile</h3>
  <p>Aplicația <strong>SafeAlert</strong> este un sistem dedicat sprijinirii victimelor violenței domestice printr-un mecanism discret de alertare și gestionare a cazurilor.</p>
  <p>Toate datele sunt confidențiale și accesibile doar utilizatorilor autentificați în platformă.</p>
</div>

<?php include 'footer.php'; ?>
