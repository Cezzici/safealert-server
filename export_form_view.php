<?php
ob_clean(); // Curăță bufferul
require('fpdf.php');
require_once 'db.php'; // Asta îți aduce conexiunea $conn

function faraDiacritice($string) {
  $map = [
    'ă'=>'a', 'â'=>'a', 'î'=>'i', 'ș'=>'s', 'ț'=>'t',
    'Ă'=>'A', 'Â'=>'A', 'Î'=>'I', 'Ș'=>'S', 'Ț'=>'T',
    '’' => "'", '“' => '"', '”' => '"'
  ];
  return strtr($string, $map);
}

if (!isset($_GET['form_id']) || !is_numeric($_GET['form_id'])) {
  die('Lipsa ID formular.');
}

$form_id = (int)$_GET['form_id'];
$stmt = $conn->prepare("SELECT * FROM forms WHERE form_id = ?");
$stmt->bind_param("i", $form_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die('Formular inexistent.');
}

$form = $result->fetch_assoc();

// Initialize PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header
$pdf->SetFillColor(94, 66, 131);
$pdf->SetTextColor(255);
$pdf->Cell(190, 15, 'SafeAlert - Raport Formular', 0, 1, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);

// General info
$pdf->Cell(60, 10, 'ID Formular:', 0, 0);
$pdf->Cell(130, 10, $form['form_id'], 0, 1);

$pdf->Cell(60, 10, 'Cod Intern:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($form['code'] ?? '-'), 0, 1);

$pdf->Cell(60, 10, 'ID Alerta:', 0, 0);
$pdf->Cell(130, 10, $form['alert_id'] ?? '-', 0, 1);

$pdf->Cell(60, 10, 'Data trimitere:', 0, 0);
$pdf->Cell(130, 10, $form['created_at'], 0, 1);

$pdf->Cell(60, 10, 'Nivel gravitate:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($form['severity']), 0, 1);

$pdf->Cell(60, 10, 'Locatie:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($form['location']), 0, 1);

$pdf->Cell(60, 10, 'Autoritate desemnata:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($form['authority_id'] ?? '-'), 0, 1);

$pdf->Cell(60, 10, 'Status:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($form['status'] ?? '-'), 0, 1);

// Details section
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Mesaj complet:', 0, 1);
$pdf->SetFont('Arial', '', 11);

$details = trim($form['details']);
if ($details === '') {
  $details = '[Fara continut]';
}
$pdf->MultiCell(0, 8, faraDiacritice($details));

// Footer spacing
$currentY = $pdf->GetY();
$linesNeeded = max(0, 260 - $currentY);
$pdf->Ln($linesNeeded);

$pdf->SetFont('Arial', 'I', 10);
$pdf->SetTextColor(150);
$pdf->Cell(0, 10, 'Acest document a fost generat automat prin SafeAlert.', 0, 0, 'C');

// Output PDF inline
$pdf->Output('I', 'Formular_SafeAlert_'.$form['form_id'].'.pdf');
exit;
