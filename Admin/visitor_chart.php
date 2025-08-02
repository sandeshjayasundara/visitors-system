<?php
session_start();
if (!isset($_SESSION['user_role'])) {
    header("Location: ../login.php");
    exit();
}

require_once '../includes/db.php'; // DB connection include

// Get all NICs from database
$query = "SELECT nic FROM visitors";
$result = $conn->query($query);

// Count males and females based on NIC
$maleCount = 0;
$femaleCount = 0;

while ($row = $result->fetch_assoc()) {
    $nic = $row['nic'];

    // Assume old NIC format (9 digits + V/X) or new format (12 digits)
    if (strlen($nic) >= 9) {
        // Extract gender digit (9th character for old, 5th-7th for new NIC)
        $genderCode = (strlen($nic) == 10) ? substr($nic, 2, 3) : substr($nic, 4, 3);

        if (is_numeric($genderCode)) {
            if ($genderCode > 500) {
                $femaleCount++;
            } else {
                $maleCount++;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Visitors by Gender (Based on NIC)</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Center and expand chart canvas */
        #genderChart {
            max-width: 600px;
            width: 100%;
            height: auto;
            margin: 0 auto;
        }

        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
    </style>
</head>
<body>
    <h2>Visitors by Gender (Based on NIC)</h2>
    <canvas id="genderChart"></canvas>

    <script>
        const ctx = document.getElementById('genderChart').getContext('2d');
        const genderChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Male', 'Female'],
                datasets: [{
                    data: [<?php echo $maleCount; ?>, <?php echo $femaleCount; ?>],
                    backgroundColor: ['#36A2EB', '#FF6384']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    title: {
                        display: true,
                        text: 'Gender Distribution Based on NIC'
                    }
                }
            }
        });
    </script>
</body>
</html>
