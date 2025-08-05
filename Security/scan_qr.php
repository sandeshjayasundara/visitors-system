<!DOCTYPE html>
<html>
<head>
  <title>Upload PDF to Scan QR</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      text-align: center;
      padding-top: 50px;
    }
    input[type="file"] {
      margin: 20px;
    }
  </style>
</head>
<body>
  <h2>📄 Upload PDF to Scan Visitor QR</h2>
  <form action="process_pdf_qr.php" method="POST" enctype="multipart/form-data">
    <input type="file" name="pdf_file" accept="application/pdf" required>
    <br>
    <button type="submit">Scan QR</button>
  </form>
</body>
</html>
