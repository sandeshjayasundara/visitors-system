<?php
require_once('../tcpdf/tcpdf.php');
include("../connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM visitors WHERE id = $id");
    $visitor = $result->fetch_assoc();

    // Create new PDF document
    $pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Visitor System');
    $pdf->SetTitle('Visitor Details');
    $pdf->AddPage();

    // Visitor details table
    $html = '
    <h2>Visitor Details</h2>
    <table border="1" cellpadding="5">
        <tr><td><strong>ID</strong></td><td>' . $visitor['id'] . '</td></tr>
        <tr><td><strong>Name</strong></td><td>' . htmlspecialchars($visitor['name']) . '</td></tr>
        <tr><td><strong>Email</strong></td><td>' . htmlspecialchars($visitor['email']) . '</td></tr>
        <tr><td><strong>Phone</strong></td><td>' . htmlspecialchars($visitor['phone']) . '</td></tr>
        <tr><td><strong>Visit Purpose</strong></td><td>' . htmlspecialchars($visitor['purpose']) . '</td></tr>
        <tr><td><strong>Visit Date</strong></td><td>' . $visitor['visit_date'] . '</td></tr>
        <tr><td><strong>Created At</strong></td><td>' . $visitor['created_at'] . '</td></tr>
    </table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // Add space before QR Code
    $pdf->Ln(10); // Add vertical space (10mm)

    // Prepare visitor data for QR Code
    $qrData = "Visitor ID: {$visitor['id']}\nName: {$visitor['name']}\nEmail: {$visitor['email']}\nPhone: {$visitor['phone']}\nPurpose: {$visitor['purpose']}\nVisit Date: {$visitor['visit_date']}";

    // Generate QR Code BELOW the table
    $pdf->write2DBarcode($qrData, 'QRCODE,H', '', '', 40, 40, null, 'N');

    // Output PDF to browser
    $pdf->Output('visitor_details.pdf', 'I');
} else {
    echo "No visitor ID selected.";
}
?>
