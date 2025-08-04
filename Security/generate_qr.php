<?php
require_once '../vendor/autoload.php';

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

// ==== STEP 1: Generate QR Code ====
$data = 'https://your-website.com/visitor?id=123'; // Change this to dynamic visitor URL
$qr = QrCode::create($data)
    ->setEncoding(new Encoding('UTF-8'))
    ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
    ->setSize(300)
    ->setMargin(10);

// ==== STEP 2: Create Writer ====
$writer = new PngWriter();
$result = $writer->write($qr);

// ==== STEP 3: Save as PNG File ====
$filename = '../qr_codes/visitor_123.png'; // make sure this folder exists and is writable
$result->saveToFile($filename);

// ==== STEP 4: Output as image to browser (optional view) ====
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
exit;
