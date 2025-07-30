<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
include("../includes/db.php");

$result = $conn->query("SELECT * FROM visitors ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Visitors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>🛂 Visitor Management</h2>
    <a href="add_visitor.php" class="btn btn-success mb-3">➕ Add Visitor</a>
    <a href="../logout.php" class="btn btn-danger mb-3 float-end">Logout</a>
    
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>NIC</th>
                <th>Visit Date</th>
                <th>Purpose</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= $row['nic'] ?></td>
                <td><?= $row['visit_date'] ?></td>
                <td><?= $row['purpose'] ?></td>
                <td>
                    <a href="edit_visitor.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">✏️ Edit</a>
                    <a href="delete_visitor.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this visitor?')">🗑️ Delete</a>
                    <a href="view_visitor.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-info">👁️ View</a>
                    <a href="scan_qr.php" class="btn btn-primary">📷 Scan Visitor QR</a>


                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
