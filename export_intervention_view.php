<?php
require_once 'db.php';
require_once 'fpdf.php';

function faraDiacritice($string) {
  $map = [
    'ă'=>'a', 'â'=>'a', 'î'=>'i', 'ș'=>'s', 'ț'=>'t',
    'Ă'=>'A', 'Â'=>'A', 'Î'=>'I', 'Ș'=>'S', 'Ț'=>'T',
    '’' => "'", '“' => '"', '”' => '"'
  ];
  return strtr($string, $map);
}

$intervention_id = $_GET['intervention_id'] ?? null;
if (!$intervention_id || !is_numeric($intervention_id)) {
  die("ID intervenție lipsă sau invalid.");
}

$stmt = $conn->prepare("
    SELECT i.*, f.code AS form_code 
    FROM interventions i 
    LEFT JOIN forms f ON i.form_id = f.form_id 
    WHERE i.intervention_id = ?
");
$stmt->bind_param("i", $intervention_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Intervenția nu a fost găsită.");
}

$interv = $result->fetch_assoc();

// Initialize PDF
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 16);

// Header
$pdf->SetFillColor(94, 66, 131);
$pdf->SetTextColor(255);
$pdf->Cell(190, 15, 'SafeAlert - Raport Interventie', 0, 1, 'C', true);

$pdf->Ln(5);
$pdf->SetTextColor(0);
$pdf->SetFont('Arial', '', 12);

// General info
$pdf->Cell(60, 10, 'ID Interventie:', 0, 0);
$pdf->Cell(130, 10, $interv['intervention_id'], 0, 1);

$pdf->Cell(60, 10, 'Cod Formular:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($interv['form_code'] ?? '-'), 0, 1);

$pdf->Cell(60, 10, 'Tip Interventie:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($interv['intervention_type']), 0, 1);

$pdf->Cell(60, 10, 'Responsabil:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($interv['responsible_person']), 0, 1);

$pdf->Cell(60, 10, 'Status:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($interv['status']), 0, 1);

$pdf->Cell(60, 10, 'Data:', 0, 0);
$pdf->Cell(130, 10, faraDiacritice($interv['created_at']), 0, 1);

// Details section
$pdf->Ln(8);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(190, 10, 'Detalii Interventie:', 0, 1);
$pdf->SetFont('Arial', '', 11);

$details = trim($interv['details']);
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
$pdf->Output('I', 'Interventie_SafeAlert_'.$intervention_id.'.pdf');
exit;
