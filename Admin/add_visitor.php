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
    <title>Add New Visitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
      
    body {
            background-color: #13e1ccff;
        }


    .container {
        background-color: rgba(228, 29, 215, 0.95);
        padding: 30px;
        border-radius: 15px;
        max-width: 700px;
        margin: 60px auto;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.3);
    }


     
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 500;
        }

        .btn-primary {
            background-color: #0069d9;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card p-4">
        <h3 class="mb-4 text-center text-primary">➕ Add New Visitor</h3>
        <form method="POST" action="">
            <div class="mb-3">
                <label class="form-label">Visitor Name</label>
                <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">NIC Number</label>
                <input type="text" name="nic" class="form-control" placeholder="Enter NIC number" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Visit Date</label>
                <input type="date" name="visit_date" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Purpose</label>
                <input type="text" name="purpose" class="form-control" placeholder="Reason for visit" required>
            </div>
            <div class="d-flex justify-content-between">
                <a href="dashboard.php" class="btn btn-secondary">⬅ Back</a>
                <button type="submit" class="btn btn-primary">✅ Submit</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
