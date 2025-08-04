<?php
include("includes/db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    $admin_code = $_POST['admin_code'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $expected_code = "SECRET2025"; // Set your own code

    if (!preg_match("/^[a-zA-Z]+$/", $username)) {
        $message = "For the Username need to letters only.";
    } elseif ($admin_code !== $expected_code) {
        $message = "Invalid admin code. Registration denied.";
    } else {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $username, $email, $password, $role);

        if ($stmt->execute()) {
            $message = "Register Complete!";
        } else {
            $message = "Failed: " . $conn->error;
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Register Form</h2>
    <?php if ($message): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" required class="form-control" pattern="[A-Za-z]+" title="Only letters allowed">
        </div>
        <div class="mb-3">
            <label>Email:</label>
            <input type="email" name="email" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Password:</label>
            <input type="password" name="password" required class="form-control">
        </div>
        <div class="mb-3">
            <label>Role:</label>
            <select name="role" class="form-select" required>
                <option value="admin">Admin</option>
                <option value="security">Security</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Admin Secret Code:</label>
            <input type="text" name="admin_code" required class="form-control">
        </div>
        <button class="btn btn-primary" type="submit">Register</button>
    </form>
</div>
</body>
</html>
