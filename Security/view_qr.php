<?php
$filename = '../qr_codes/visitor_123.png'; // same path used above
?>

<!DOCTYPE html>
<html>
<head>
    <title>Download Visitor QR</title>
</head>
<body>
    <h2>Visitor QR Code</h2>
    <img src="<?php echo $filename; ?>" alt="QR Code" width="300"><br><br>
    <a href="<?php echo $filename; ?>" download>📥 Download QR Code</a>
</body>
</html>
