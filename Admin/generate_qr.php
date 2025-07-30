<?php
require_once('../vendor/autoload.php'); // or include your phpqrcode lib if using manually

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

$visitor_id = $_GET['id'] ?? '1'; // default ID

$qr = QrCode::create($visitor_id)
    ->setSize(300)
    ->setMargin(10);

$writer = new PngWriter();
$result = $writer->write($qr);

// Output the QR code
header('Content-Type: '.$result->getMimeType());
echo $result->getString();
?>
