<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'security') {
    header("Location: ../login.php");
    exit();
}

include("../includes/db.php");

$result = $conn->query("SELECT * FROM visitors ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Visitors</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <style>
        body {
            background-color: #f5f7fa; /* Light gray-blue background */
        }

        .container {
            background-color: #0fa9f6ff; /* White container */
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 25px;
        }

        h2 {
            color: #333;
            font-weight: bold;
        }

        table th {
            background-color: #343a40;
            color: white;
        }

        table td, table th {
            vertical-align: middle !important;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4"> Visitors Details</h2>
   

    <table class="table table-striped table-bordered">
        <thead>
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
            <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['nic']) ?></td>
                <td><?= $row['visit_date'] ?></td>
                <td><?= htmlspecialchars($row['purpose']) ?></td>
                <td>
                    <a href="generate_qr.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm" target="_blank">QR<a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary mt-3">⬅️ Back to Dashboard</a>
</div>
</body>
</html>
