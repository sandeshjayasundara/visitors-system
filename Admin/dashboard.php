<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Visitor Management System</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      display: flex;
      align-items: center;
      padding: 12px;
      text-decoration: none;
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
      background-color: #ac0b0bff;
      padding: 20px;
    }
    .header {
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: #b716b7ff;
      padding: 15px 20px;
      box-shadow: 0 2px 4px rgba(236, 229, 229, 0.67);
      position: relative;
    }
    .header-title {
      font-size: 24px;
      font-weight:bold;
      text-align: center;
    }
    .user-role {
      position: absolute;
      right: 20px;
      font-size: 16px;
      font-weight: 500;
    }
    .card canvas {
      height: 60px !important;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
  <a href="#"><i class="fas fa-tachometer-alt"></i>Dashboard</a>
  <a href="add_visitor.php"><i class="fas fa-user-plus"></i>New Visitor Add</a>
  <a href="manage_visitors.php"><i class="fas fa-users-cog"></i>Manage Visitor</a>
  <a href="visitor_details.php"><i class="fas fa-address-card"></i>Visitors Details</a>
  <a href="#"><i class="fas fa-question-circle"></i>FAQ</a>
  <a href="../logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
</div>

<!-- Main Content -->
<div class="main-content">
  <div class="header">
    <div class="header-title">Visitor Management System</div>
    <div class="user-role">Admin</div>
  </div>

  <div class="content-body mt-4">
    <!-- Centered Summary Cards -->
    <div class="d-flex justify-content-center">
      <div class="row mb-4" style="max-width: 1140px; width: 100%;">
        <div class="col-md-3">
          <div class="card text-white bg-primary">
            <div class="card-body">
              <h5 class="card-title">Total Visitors</h5>
              <canvas id="totalVisitorsChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-white bg-success">
            <div class="card-body">
              <h5 class="card-title">Today's Visitors</h5>
              <canvas id="todaysVisitorsChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-white bg-warning">
            <div class="card-body">
              <h5 class="card-title">Yesterday's Visitors</h5>
              <canvas id="yesterdaysVisitorsChart"></canvas>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card text-white bg-danger">
            <div class="card-body">
              <h5 class="card-title">Last 7 Days</h5>
              <canvas id="last7DaysChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
