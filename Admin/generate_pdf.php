<?php
require_once('../tcpdf/tcpdf.php'); // path to your tcpdf folder

include("../connect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM visitors WHERE id = $id");
    $visitor = $result->fetch_assoc();

    // Create new PDF document
    $pdf = new tcpdf();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Visitor System');
    $pdf->SetTitle('Visitor Details');
    $pdf->AddPage();

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
    $pdf->Output('visitor_details.pdf', 'I'); // Display in browser
} else {
    echo "No visitor ID selected.";
}
?>
