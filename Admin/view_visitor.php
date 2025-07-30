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
</head>
<body>
<div class="container mt-4">
    <h2>Visitor Details</h2>
    <table class="table table-bordered">
        <tr><th>ID</th><td><?= $visitor['id'] ?></td></tr>
        <tr><th>Name</th><td><?= htmlspecialchars($visitor['name']) ?></td></tr>
        <tr><th>Email</th><td><?= htmlspecialchars($visitor['email'?? 'N/A']) ?></td></tr>
        <tr><th>Phone</th><td><?= htmlspecialchars($visitor['phone'] ?? 'N/A') ?></td></tr>
        <tr><th>Visit Purpose</th><td><?= htmlspecialchars($visitor['purpose']) ?></td></tr>
        <tr><th>Visit Date</th><td><?= $visitor['visit_date'] ?></td></tr>
        <tr><th>Created At</th><td><?= $visitor['created_at' ?? 'N/A'] ?></td></tr>
    </table>
    <a href="dashboard.php" class="btn btn-secondary">⬅️ Back to Dashboard</a>
    <a href="generate_pdf.php?id=<?= $visitor['id'] ?>" class="btn btn-primary" target="_blank">🧾 Export as PDF</a>

</div>
</body>
</html>
