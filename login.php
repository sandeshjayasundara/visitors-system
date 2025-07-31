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
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visitor Management - Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('img.jpg') ;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      background-color: rgba(154, 19, 195, 0.9);
      backdrop-filter: blur(5px);
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .card-header {
      background-color: #22abb2ff;
      color: white;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
    }
    .card-footer {
      text-align: center;
    }
    .form-label {
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header text-center">
            <h4>Visitor Management System</h4>
          </div>
          <div class="card-body">
            <form action="login.php" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">Login</button>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <small>Not registered? <a href="register.php">Register here</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
