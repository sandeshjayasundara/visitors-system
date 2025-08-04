<!DOCTYPE html>
<html>
<head>
  <title>QR Code Scanner</title>
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
  <style>
    #reader {
      width: 400px;
      margin: auto;
      padding-top: 50px;
    }
    #result {
      text-align: center;
      margin-top: 20px;
      font-size: 18px;
    }
  </style>
</head>
<body>
  <h2 style="text-align:center;">🔍 Scan Visitor QR Code</h2>

  <div id="reader"></div>
  <div id="result">Scanned Visitor ID: <span id="visitorId"></span></div>

  <script>
    function onScanSuccess(decodedText, decodedResult) {
      document.getElementById('visitorId').innerText = decodedText;
      
      // Redirect to view_visitor.php with ID
      window.location.href = "view_visitor.php?id=" + decodedText;
    }

    let html5QrcodeScanner = new Html5QrcodeScanner(
      "reader", { fps: 10, qrbox: 250 });

    html5QrcodeScanner.render(onScanSuccess);
  </script>
</body>
</html>
