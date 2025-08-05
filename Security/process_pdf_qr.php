<?php
require_once __DIR__ . '../vendor/autoload.php';

use Smalot\PdfParser\Parser;
use Endroid\QrCode\Reader\QrReader;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $fileTmpPath = $_FILES['pdf_file']['tmp_name'];

   
    $parser = new Parser();
    $pdf = $parser->parseFile($fileTmpPath);
    $pages = $pdf->getPages();

    $found = false;

    foreach ($pages as $page) {
        $text = $page->getText();
        
       
        if (preg_match('/Visitor ID:\s*(\d+)/', $text, $matches)) {
            $visitorId = $matches[1];
            $found = true;
            break;
        }
    }

    if ($found) {
        // Redirect to view page
        header("Location: view_visitor.php?id=$visitorId");
        exit();
    } else {
        echo "<h3>QR Code not found or unreadable.</h3>";
    }
} else {
    echo "Invalid request.";
}
