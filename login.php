<?php
session_start();
require_once "includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $error = " සියලුම කොටස් පුරවන්න.";
    } else {
        $stmt = $conn->prepare("SELECT id, username, password, role, profile_image FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $username, $hashed_password, $role, $profile_image);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION["user_id"] = $id;
                $_SESSION["username"] = $username;
                $_SESSION["user_role"] = $role;
                $_SESSION["profile_image"] = $profile_image;

                // Redirect based on role
                if ($role === "admin") {
                    header("Location: Admin/dashboard.php");
                    exit;
                } elseif ($role === "security") {
                    header("Location: Security/dashboard.php");
                    exit;
                } else {
                    $error = " අනීතික භූමිකාවක්.";
                }
            } else {
                $error = " මුරපදය වැරදියි.";
            }
        } else {
            $error = " පරිශීලකයෙකු සොයාගත නොහැක.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Visitor Management - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('img.jpg') no-repeat center center fixed;
      background-size: cover;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .card {
      background-color: rgba(0, 0, 0, 0.7);
      color: white;
      border-radius: 15px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.3);
    }

    .card-header {
      background-color: #22abb2;
      color: white;
      border-top-left-radius: 15px;
      border-top-right-radius: 15px;
      text-align: center;
      font-weight: bold;
    }

    .form-label {
      font-weight: bold;
    }

    .btn-primary {
      background-color: #22abb2;
      border: none;
    }

    .btn-primary:hover {
      background-color: #1a8c95;
    }

    .error-message {
      color: #ffc107;
      margin-bottom: 15px;
      text-align: center;
    }

    .card-footer {
      text-align: center;
      background: transparent;
      color: #ccc;
    }

    .card-footer a {
      color: #0fdfe9;
      text-decoration: none;
    }

    .card-footer a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card">
          <div class="card-header">
            <h4>Visitor Management Login</h4>
          </div>
          <div class="card-body">
            <?php if (!empty($error)): ?>
              <div class="error-message"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="login.php" method="POST">
              <div class="mb-3">
                <label for="email" class="form-label">ඊමේල් ලිපිනය</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Enter your email" required>
              </div>
              <div class="mb-3">
                <label for="password" class="form-label">මුරපදය</label>
                <input type="password" name="password" class="form-control" id="password" placeholder="Enter your password" required>
              </div>
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">පිවිසෙන්න</button>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <small>නව පරිශීලකයෙක්ද? <a href="register.php">ලියාපදිංචි වන්න</a></small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
