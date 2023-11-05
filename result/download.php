<?php
require_once('tcpdf/tcpdf.php');

// Prevent any output before generating the PDF
ob_start();

// Create a PDF instance
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set document information (optional)
$pdf->SetCreator('Your Name');
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Generated PDF');
$pdf->SetSubject('Generated PDF');
$pdf->SetKeywords('PDF, example, tutorial');

// Set default font
$pdf->SetFont('helvetica', '', 12);

// Add a page
$pdf->AddPage();

// Capture the current page's HTML content
$html = ob_get_clean();

// Add the captured HTML content to the PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output the PDF for download
$pdf->Output('generated_pdf.pdf', 'D');

// Close the PDF instance
$pdf->Close();
?>
