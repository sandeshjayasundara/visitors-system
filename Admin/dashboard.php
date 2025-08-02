<?php
session_start();
require_once("../includes/db.php");

// Fetch user info from session
$profileImage = $_SESSION['profile_image'] ?? 'default.png';
$username = $_SESSION['username'] ?? 'User';
$userRole = $_SESSION['user_role'] ?? 'Role';

// Total Visitors
$total_query = $conn->query("SELECT COUNT(*) as total FROM visitors");
$total_visitors = $total_query->fetch_assoc()['total'];

// Today Visitors
$today_query = $conn->query("SELECT COUNT(*) as today FROM visitors WHERE DATE(visit_date) = CURDATE()");
$today_visitors = $today_query->fetch_assoc()['today'];

// Yesterday Visitors
$yesterday_query = $conn->query("SELECT COUNT(*) as yesterday FROM visitors WHERE DATE(visit_date) = CURDATE() - INTERVAL 1 DAY");
$yesterday_visitors = $yesterday_query->fetch_assoc()['yesterday'];

// Last 7 Days Visitors
$week_query = $conn->query("SELECT COUNT(*) as week FROM visitors WHERE visit_date >= CURDATE() - INTERVAL 7 DAY");
$week_visitors = $week_query->fetch_assoc()['week'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Visitor Management System</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    body {
      display: flex;
      margin: 0;
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .sidebar {
      width: 240px;
      background-color: #343a40;
      color: white;
      display: flex;
      flex-direction: column;
    }

    .sidebar-profile {
      text-align: center;
      padding: 20px;
      border-bottom: 1px solid #555;
    }

    .sidebar-profile img {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid #4CAF50;
    }

    .sidebar-profile h5 {
      margin-top: 10px;
      margin-bottom: 0;
    }

    .sidebar-profile p {
      margin: 5px 0 0;
      font-size: 14px;
      color: #ccc;
    }

    .sidebar a {
      color: white;
      display: flex;
      align-items: center;
      padding: 12px 20px;
      text-decoration: none;
      transition: 0.2s;
    }

    .sidebar a i {
      margin-right: 10px;
      width: 20px;
      text-align: center;
    }

    .sidebar a:hover {
      background-color: #0d0e0eff;
    }

    .main-content {
      flex-grow: 1;
      background-color: #f2f2f2;
      padding: 20px;
    }

    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #0fde76ff;
      padding: 15px 20px;
      border-radius: 6px;
    }

    .header-title {
      font-size: 24px;
      font-weight: bold;
      color: #000;
    }

    .user-role {
      font-size: 16px;
      font-weight: 500;
      color: #000;
    }

    .card h5 {
      font-weight: 600;
    }

    .card p {
      font-size: 1.5rem;
      font-weight: bold;
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

    <!-- Navigation Links -->
    <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="add_visitor.php"><i class="fas fa-user-plus"></i> New Visitor Add</a>
    <a href="manage_visitors.php"><i class="fas fa-users-cog"></i> Manage Visitors</a>
    <a href="visitor_details.php"><i class="fas fa-address-card"></i> Visitors Details</a>
    <a href="#"><i class="fas fa-question-circle"></i> FAQ</a>
    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="header mb-4">
      <div class="header-title">Visitor Management System</div>
      <div class="user-role"><?php echo ucfirst($userRole); ?></div>
    </div>

    <!-- Stats Cards -->
    <div class="row">
      <div class="col-md-3 mb-3">
        <div class="card text-white bg-primary">
          <div class="card-body">
            <h5 class="card-title">Total Visitors</h5>
            <p class="card-text"><?= $total_visitors ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-3">
        <div class="card text-white bg-success">
          <div class="card-body">
            <h5 class="card-title">Today's Visitors</h5>
            <p class="card-text"><?= $today_visitors ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-3">
        <div class="card text-white bg-warning">
          <div class="card-body">
            <h5 class="card-title">Yesterday's Visitors</h5>
            <p class="card-text"><?= $yesterday_visitors ?></p>
          </div>
        </div>
      </div>

      <div class="col-md-3 mb-3">
        <div class="card text-white bg-danger">
          <div class="card-body">
            <h5 class="card-title">Last 7 Days</h5>
            <p class="card-text"><?= $week_visitors ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
