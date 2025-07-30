<?php
session_start();
require_once "includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Validation
    if (empty($email) || empty($password)) {
        $error = "සියලුම කොටස් පුරවන්න.";
    } else {
        // Prepared Statement to avoid SQL Injection
        $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Check if user exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password, $role);
            $stmt->fetch();

            // Verify password
            if (password_verify($password, $hashed_password)) {
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["user_role"] = $role;

                // Redirect based on role
                if ($role === "admin") {
                    header("Location: Admin/dashboard.php");
                    exit;
                } elseif ($role === "security") {
                    header("Location: Security/dashboard.php");
                    exit;
                } else {
                    $error = "අනීතික භූමිකාවක්.";
                }
            } else {
                $error = "මුරපදය වැරදියි.";
            }
        } else {
            $error = "පරිශීලකයෙකු සොයාගත නොහැක.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="si">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card shadow">
          <div class="card-header text-center">
            <h4>VISITORS MANAGEMENT SYSTEM <br>Login Panel</h4>
          </div>
          <div class="card-body">
            <?php if (!empty($error)): ?>
              <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            <form method="POST" action="">
              <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
              </div>
              <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
          <div class="card-footer text-center">
            <small>Not registered? <a href="register.php">Register here</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
