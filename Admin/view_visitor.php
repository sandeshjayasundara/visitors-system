<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include("../includes/db.php");

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit();
}

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM visitors WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$visitor = $result->fetch_assoc();

if (!$visitor) {
    echo "Visitor not found.";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Visitor Details</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to right, #2c76c0ff, #cfdef3);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        .full-container {
            width: 100%;
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            justify-content: center;
            align-items: start;
        }

        .content-box {
            width: 100%;
            max-width: 1000px;
            background: #31d1cbff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #343a40;
            margin-bottom: 40px;
            text-align: center;
            font-weight: bold;
        }

        .table th {
            width: 30%;
            background-color: #15e654ff;
            font-weight: 600;
            color: #495057;
        }

        .table td {
            background-color: #e5edefff;
        }

        .table-bordered > tbody > tr {
            margin-bottom: 20px;
            border-bottom: 1px solid #dde3e9ff;
        }

        .table-bordered > tbody > tr > td,
        .table-bordered > tbody > tr > th {
            padding: 20px;
            vertical-align: middle;
            font-size: 16px;
        }

        .btn {
            margin-top: 20px;
            margin-right: 15px;
        }
    </style>
</head>
<body>
<div class="full-container">
    <div class="content-box">
        <h2>Visitor Details</h2>
        <table class="table table-bordered">
            <tr><th>ID</th><td><?= htmlspecialchars($visitor['id']) ?></td></tr>
            <tr><th>Name</th><td><?= htmlspecialchars($visitor['name']) ?></td></tr>
            <tr><th>Email</th><td><?= htmlspecialchars($visitor['email'] ?? 'N/A') ?></td></tr>
            <tr><th>Phone</th><td><?= htmlspecialchars($visitor['phone'] ?? 'N/A') ?></td></tr>
            <tr><th>Visit Purpose</th><td><?= htmlspecialchars($visitor['purpose']) ?></td></tr>
            <tr><th>Visit Date</th><td><?= htmlspecialchars($visitor['visit_date']) ?></td></tr>
            <tr><th>Created At</th><td><?= htmlspecialchars($visitor['created_at'] ?? 'N/A') ?></td></tr>
        </table>
        <a href="dashboard.php" class="btn btn-secondary">⬅️ Back to Dashboard</a>
        <a href="generate_pdf.php?id=<?= $visitor['id'] ?>" class="btn btn-primary" target="_blank">🧾 Export as PDF</a>
    </div>
</div>
</body>
</html>
