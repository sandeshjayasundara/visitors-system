<?php
require_once '../vendor/autoload.php';

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

$result = Builder::create()
    ->writer(new PngWriter())
    ->data('https://example.com')
    ->build();

header('Content-Type: '.$result->getMimeType());
echo $result->getString();
