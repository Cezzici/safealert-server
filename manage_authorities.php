<?php
require_once 'header.php';
require_once 'db.php';

if ($_SESSION['role'] !== 'admin') {
  echo '<div class="card"><p>Acces interzis.</p></div>';
  include 'footer.php';
  exit();
}

// La trimitere formular
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $authority_id = trim($_POST['authority_id']);     // varchar(50), PK
  $name = trim($_POST['name']);                     // varchar(255)
  $type = trim($_POST['type']);                     // varchar(100)
  $region = trim($_POST['region']);                 // varchar(100)
  $contact = trim($_POST['contact_details']);       // varchar(100)
  $person = trim($_POST['contact_person']);         // varchar(100)
  $status = strtolower(trim($_POST['status']));     // varchar(50), lowercase

  // Validare minimă
  if (!$authority_id || !$name || !$type || !$region || !in_array($status, ['activ', 'inactiv'])) {
    die("Date obligatorii lipsă sau invalide.");
  }

  $stmt = $conn->prepare("INSERT INTO authorities 
    (authority_id, name, type, region, contact_details, contact_person, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
  
  if (!$stmt) {
    die("Eroare pregătire interogare: " . $conn->error);
  }

  $stmt->bind_param("sssssss", $authority_id, $name, $type, $region, $contact, $person, $status);

  if ($stmt->execute()) {
    header("Location: view_authorities.php");
    exit();
  } else {
    die("Eroare la inserare: " . $stmt->error);
  }
}
?>

<div class="card">
  <h2>➕ Adaugă autoritate nouă</h2>
  <form method="post">
    <label>ID autoritate (ex. AUT-20250520-001):</label><br>
    <input type="text" name="authority_id" required style="width:100%; padding:8px; margin-bottom:10px;"><br>

    <label>Nume autoritate:</label><br>
    <input type="text" name="name" required style="width:100%; padding:8px; margin-bottom:10px;"><br>

    <label>Tip:</label><br>
    <input type="text" name="type" required style="width:100%; padding:8px; margin-bottom:10px;"><br>

    <label>Regiune:</label><br>
    <input type="text" name="region" required style="width:100%; padding:8px; margin-bottom:10px;"><br>

    <label>Detalii contact (email, telefon):</label><br>
    <input type="text" name="contact_details" style="width:100%; padding:8px; margin-bottom:10px;"><br>

    <label>Persoană de contact:</label><br>
    <input type="text" name="contact_person" style="width:100%; padding:8px; margin-bottom:10px;"><br>

    <label>Status:</label><br>
    <select name="status" style="width:100%; padding:8px; margin-bottom:20px;">
      <option value="activ">ACTIV</option>
      <option value="inactiv">INACTIV</option>
    </select><br>

    <input type="submit" value="Adaugă autoritatea" style="background-color:#5e4283; color:white; padding:10px 20px; border:none; border-radius:6px; font-weight:bold;">
  </form>

  <div style="margin-top: 20px;">
    <a href="view_authorities.php" style="text-decoration:none;">⬅️ Înapoi la lista autorităților</a>
  </div>
</div>

<?php include 'footer.php'; ?>
