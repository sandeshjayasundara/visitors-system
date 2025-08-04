<?php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'security') {
    header("Location: ../login.php");
    exit();
}
include("../includes/db.php");

$userRole = $_SESSION['user_role'];
$username = $_SESSION['username'] ?? 'Guest';
$profileImage = $_SESSION['profile_image'] ?? 'default.png';

$result = $conn->query("SELECT * FROM visitors ORDER BY id DESC");
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Visitor Dashboard</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #8be5ecff;
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100vh;
      background-color: #343a40;
      padding-top: 20px;
      overflow-y: auto;
    }

    .sidebar a {
      display: block;
      color: white;
      padding: 12px 20px;
      text-decoration: none;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: #495057;
      text-decoration: none;
    }

    .main-content {
      margin-left: 250px;
      padding: 30px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 30px;
      padding: 10px 20px;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .header-title {
      font-size: 24px;
      font-weight: 600;
    }

    .user-role {
      font-size: 16px;
      color: #555;
    }

    .sidebar-profile img {
      box-shadow: 0 0 5px rgba(10, 178, 228, 0.8);
    }

    @media screen and (max-width: 768px) {
      .sidebar {
        width: 100%;
        height: auto;
        position: relative;
      }

      .main-content {
        margin-left: 0;
        padding: 15px;
      }
      

    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <!-- Profile Section -->
  <div class="sidebar-profile" style="text-align: center; padding: 15px;">
    <img src="../uploads/<?php echo htmlspecialchars($profileImage); ?>" 
         alt="Profile Picture" 
         style="width: 70px; height: 70px; border-radius: 50%; object-fit: cover; border: 2px solid #fff;">
    
    <h5 style="color: white; margin-top: 8px;"><?php echo htmlspecialchars($username); ?></h5>
    
    <p style="color: white; margin: 0;"><?php echo ucfirst($userRole); ?> - 
      <span style="color: lightgreen;">🟢 Online</span>
    </p>
  </div>
  <a href="visitor_details1.php"><i class="fas fa-address-card"></i> Visitors Details</a>
  <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>
<!-- Main Content -->
<div class="main-content">
  <div class="header mb-4">
    <div class="header-title">Visitor Management System</div>
    <div class="user-role"><?php echo ucfirst($userRole); ?></div>
  </div>
</body>
</html>

