<?php
ob_clean(); // Curăță bufferul
require('fpdf.php');
require_once 'db.php'; // Asta îți aduce conexiunea $conn

function faraDiacritice($string) {
  $map = [
    'ă'=>'a', 'â'=>'a', 'î'=>'i', 'ș'=>'s', 'ț'=>'t',
    'Ă'=>'A', 'Â'=>'A', 'Î'=>'I', 'Ș'=>'S', 'Ț'=>'T',
    '’' => "'", '“' => '"', '”' => '"', '–' => '-', '—' => '-'
  ];
  return strtr($string, $map);
}

$start = $_GET['start'] ?? null;
$end = $_GET['end'] ?? null;

if (!$start || !$end) {
  die("Perioada este necesara (start=YYYY-MM-DD&end=YYYY-MM-DD).");
}

$startDate = date('Y-m-d 00:00:00', strtotime($start));
$endDate = date('Y-m-d 23:59:59', strtotime($end));

// Extragem datele
$query = $conn->prepare("
  SELECT f.created_at AS data_cerere, f.severity, f.location, f.status AS status_formular,
         f.authority_id, au.name AS user_name, i.*, f.code, f.alert_id
  FROM forms f
  JOIN app_users au ON au.user_id = f.user_id
  LEFT JOIN interventions i ON i.form_id = f.form_id
  WHERE f.created_at BETWEEN ? AND ?
");
$query->bind_param("ss", $startDate, $endDate);
$query->execute();
$result = $query->get_result();

$rows = [];
$nr_total_cereri = 0;
$nr_interventii = 0;
$nr_redirectionari = 0;
$nr_rezolvate = 0;
$nr_grav_4_5 = 0;

while ($row = $result->fetch_assoc()) {
  $nr_total_cereri++;
  $grav = intval(preg_replace('/\D/', '', $row['severity']));
  if ($grav >= 4) $nr_grav_4_5++;
  if ($row['intervention_id']) $nr_interventii++;
  if (!empty($row['authority_id'])) $nr_redirectionari++;
  if (in_array(strtolower($row['status']), ['rezolvat', 'finalizata'])) $nr_rezolvate++;
  $rows[] = $row;
}

// PDF generare
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Helvetica', 'B', 16);
$pdf->SetTextColor(123, 47, 242);
$pdf->Cell(0, 10, faraDiacritice('Raport final interventii SafeAlert'), 0, 1, 'C');

$pdf->SetTextColor(0);
$pdf->SetFont('Helvetica', '', 12);
$pdf->Cell(0, 10, 'Perioada: '.faraDiacritice(date('j F Y', strtotime($start)).' - '.date('j F Y', strtotime($end))), 0, 1, 'C');

$pdf->Ln(5);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Statistici generale:', 0, 1);
$pdf->SetFont('Helvetica', '', 11);
$pdf->Cell(0, 8, "- Numar total de cereri procesate: $nr_total_cereri", 0, 1);
$pdf->Cell(0, 8, "- Numar total de interventii realizate: $nr_interventii", 0, 1);
$pdf->Cell(0, 8, "- Cazuri redirectionate catre autoritati: $nr_redirectionari", 0, 1);
$pdf->Cell(0, 8, "- Cazuri rezolvate cu succes: $nr_rezolvate", 0, 1);

$pdf->Ln(5);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Detalii cazuri:', 0, 1);

$pdf->SetFont('Helvetica', 'B', 9);
$pdf->SetFillColor(235, 235, 235);
$pdf->Cell(30, 8, 'Nume', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Data cerere', 1, 0, 'C', true);
$pdf->Cell(20, 8, 'Nivel', 1, 0, 'C', true);
$pdf->Cell(40, 8, 'Tip', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Data interventie', 1, 0, 'C', true);
$pdf->Cell(30, 8, 'Status', 1, 1, 'C', true);

$pdf->SetFont('Helvetica', '', 9);
foreach ($rows as $r) {
  $yStart = $pdf->GetY();

  // Coloane standard
  $pdf->Cell(30, 8, faraDiacritice($r['user_name']), 1);
  $pdf->Cell(30, 8, substr($r['data_cerere'], 0, 10), 1);
  $pdf->Cell(20, 8, faraDiacritice($r['severity']), 1);

  // Coloana "Tip" cu MultiCell
  $x = $pdf->GetX();
  $y = $pdf->GetY();
  $pdf->MultiCell(40, 8, faraDiacritice($r['intervention_type'] ?? '-'), 1);
  $yEnd = $pdf->GetY();
  $pdf->SetXY($x + 40, $y);

  $height = $yEnd - $y;

  $pdf->Cell(30, $height, isset($r['created_at']) ? substr($r['created_at'], 0, 10) : '-', 1);
  $pdf->Cell(30, $height, faraDiacritice($r['status'] ?? '-'), 1);
  $pdf->Ln();
}

$pdf->Ln(8);
$pdf->SetFont('Helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Concluzii:', 0, 1);
$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell(0, 8,
  "1. Majoritatea cazurilor au fost gestionate prin interventii directe sau sprijin psihologic.\n" .
  "2. Nivelul de gravitate ridicat (4-5) a fost intalnit in aproximativ " . round($nr_grav_4_5/$nr_total_cereri*100) . "% dintre cazuri.\n" .
  "3. Colaborarea cu autoritatile a fost esentiala in cazurile critice."
);

$pdf->Ln(4);
$pdf->SetFont('Helvetica', 'B', 11);
$pdf->Cell(0, 8, 'Observatii suplimentare:', 0, 1);

$pdf->SetFont('Helvetica', '', 11);
$pdf->MultiCell(0, 8,
  "- Sugestii pentru imbunatatiri: Cresterea capacitatii centrelor din mediul rural.\n" .
  "- Planuri viitoare: Integrarea unui sistem de notificare pentru cazuri de gravitate maxima."
);

$pdf->Output('I', 'Raport_Interventii_SafeAlert.pdf');
exit;
