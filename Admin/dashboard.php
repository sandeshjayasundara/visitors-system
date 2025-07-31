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
  <title>Visitor Management System</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>
    body {
      display: flex;
      min-height: 100vh;
      margin: 0;
    }
    .sidebar {
      width: 220px;
      background-color: #343a40;
      color: white;
      padding-top: 20px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 12px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #495057;
    }
    .main-content {
      flex-grow: 1;
      background-color: #f4d212ff;
      padding: 20px;
    }
    .header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #ffffff;
      padding: 15px 20px;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .header-title {
      font-size: 20px;
      font-weight: bold;
    }
    .user-role {
      font-size: 16px;
      font-weight: 500;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <a href="#">Dashboard</a>
    <a href="add_visitor.php">New Visitor Add</a>
    <a href="manage_visitors.php">Manage Visitor</a>
    <a href="visitor_details.php">Visitors Details</a>
    <a href="#">FAQ</a>
    <a href="../logout.php">Logout</a>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <div class="header">
      <div class="header-title">Visitor Management System</div>
      <div class="user-role">Admin</div> <!-- or Guard -->
    </div>

    <div class="content-body mt-4">
      <h2>Welcome to Dashboard</h2>
      <p>This is the main content area.</p>
    </div>
  </div>

</body>
</html>

