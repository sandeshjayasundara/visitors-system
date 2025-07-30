<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

include("../includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $nic = $_POST['nic'];
    $visit_date = $_POST['visit_date'];
    $purpose = $_POST['purpose'];

    $stmt = $conn->prepare("INSERT INTO visitors (name, nic, visit_date, purpose) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $nic, $visit_date, $purpose);

    if ($stmt->execute()) {
        header("Location: dashboard.php?msg=added");
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Visitor</title>
    <img src="generate_qr.php?visitor_id=<?php echo $row['id']; ?>" width="200">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>➕ Add New Visitor</h2>
    <form method="POST" action="">
        <div class="mb-3">
            <label class="form-label">Visitor Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">NIC Number</label>
            <input type="text" name="nic" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Visit Date</label>
            <input type="date" name="visit_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Purpose</label>
            <input type="text" name="purpose" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">✅ Submit</button>
        <a href="dashboard.php" class="btn btn-secondary">⬅ Back to Dashboard</a>
    </form>
</div>
</body>
</html>
