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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $visit_date = $_POST['visit_date'];
    $purpose = $_POST['purpose'];

    $stmt = $conn->prepare("UPDATE visitors SET name=?, nic=?, visit_date=?, purpose=? WHERE id=?");
    $stmt->bind_param("ssssi", $name, $nic, $visit_date, $purpose, $id);

    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=updated");
    } else {
        echo "Update Error: " . $stmt->error;
    }
}

// Fetch visitor details
$stmt = $conn->prepare("SELECT * FROM visitors WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$visitor = $result->fetch_assoc();

if (!$visitor) {
    echo "Visitor not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Visitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>✏️ Edit Visitor</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Visitor Name</label>
            <input type="text" name="name" value="<?= $visitor['name']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">NIC Number</label>
            <input type="text" name="nic" value="<?= $visitor['nic']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Visit Date</label>
            <input type="date" name="visit_date" value="<?= $visitor['visit_date']; ?>" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Purpose</label>
            <input type="text" name="purpose" value="<?= $visitor['purpose']; ?>" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-warning">💾 Update</button>
        <a href="dashboard.php" class="btn btn-secondary">⬅ Cancel</a>
    </form>
</div>
</body>
</html>
