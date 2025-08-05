<?php
session_start();
include '../includes/db.php'; 

// Fetch data for line chart (Visitors by date)
$chartData = [];
$result = $conn->query("SELECT DATE(created_at) as date, COUNT(*) as count FROM visitors GROUP BY DATE(created_at) ORDER BY DATE(created_at) ASC");
while ($row = $result->fetch_assoc()) {
    $chartData[] = [$row['date'], (int)$row['count']];
}


// Get session data
$username = $_SESSION['username'] ?? 'Guest';
$userRole = $_SESSION['user_role'] ?? 'Unknown';
$profileImage = $_SESSION['profile_image'] ?? 'default.png';

// Visitor Stats Queries
$total_visitors = 0;
$today_visitors = 0;
$yesterday_visitors = 0;
$week_visitors = 0;

try {
    // Total Visitors
    $result = $conn->query("SELECT COUNT(*) as count FROM visitors");
    $row = $result->fetch_assoc();
    $total_visitors = $row['count'];

    // Today's Visitors
    $today = date('Y-m-d');
    $result = $conn->query("SELECT COUNT(*) as count FROM visitors WHERE DATE(created_at) = '$today'");
    $row = $result->fetch_assoc();
    $today_visitors = $row['count'];

    // Yesterday's Visitors
    $yesterday = date('Y-m-d', strtotime('-1 day'));
    $result = $conn->query("SELECT COUNT(*) as count FROM visitors WHERE DATE(created_at) = '$yesterday'");
    $row = $result->fetch_assoc();
    $yesterday_visitors = $row['count'];

    // Last 7 Days Visitors
    $lastWeek = date('Y-m-d', strtotime('-7 days'));
    $result = $conn->query("SELECT COUNT(*) as count FROM visitors WHERE DATE(created_at) >= '$lastWeek'");
    $row = $result->fetch_assoc();
    $week_visitors = $row['count'];

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
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
      background-color: #41abdcff;
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
      box-shadow: 0 0 5px rgba(255,255,255,0.8);
    }

    .card h5 {
      font-size: 18px;
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
      .card {
         cursor: pointer;
         transition: transform 0.2s;
      }
      .card:hover {
          transform: scale(1.03);
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
      <div class="card text-white bg-success" onclick="window.location.href='visitor_chart.php'">
        <div class="card-body text-center">
          <h5 class="card-title">Total Visitors</h5>
          <p class="card-text display-4"><?php echo $total_visitors; ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card text-white bg-primary">
        <div class="card-body text-center">
          <h5 class="card-title">Today's Visitors</h5>
          <p class="card-text display-4"><?= $today_visitors ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card text-white bg-warning">
        <div class="card-body text-center">
          <h5 class="card-title">Yesterday's Visitors</h5>
          <p class="card-text display-4"><?= $yesterday_visitors ?></p>
        </div>
      </div>
    </div>

    <div class="col-md-3 mb-3">
      <div class="card text-white bg-danger">
        <div class="card-body text-center">
          <h5 class="card-title">Last 7 Days</h5>
          <p class="card-text display-4"><?= $week_visitors ?></p>
        </div>
      </div>
    </div>
  </div>

  <!-- Line Chart Container -->
  <div class="card mt-4">
    <div class="card-body">
      <h5 class="card-title text-center mb-4">Visitor Trend (Daily)</h5>
      <div id="line_chart" style="width: 100%; height: 400px;"></div>
    </div>
  </div>
</div>

<!-- Google Charts Scripts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
  google.charts.load('current', {'packages':['corechart']});
  google.charts.setOnLoadCallback(drawChart);

  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['Date', 'Visitors'],
      <?php foreach ($chartData as $row) {
        echo "['{$row[0]}', {$row[1]}],";
      } ?>
    ]);

    var options = {
      title: '',
      curveType: 'function',
      legend: { position: 'bottom' },
      colors: ['#28a745'],
      vAxis: {
        minValue: 0
      }
    };

    var chart = new google.visualization.LineChart(document.getElementById('line_chart'));
    chart.draw(data, options);
  }
</script>



</body>
</html>
