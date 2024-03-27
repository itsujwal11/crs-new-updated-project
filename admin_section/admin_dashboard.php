<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "login";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch total cases reported
$sql = "SELECT COUNT(*) AS total_cases FROM report_crime";
$result = $conn->query($sql);
$total_cases = 0; // Initialize total cases variable

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $total_cases = $row["total_cases"];
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/admin1.css">
</head>
<body>
<div class="grid-container">
    <!-- Header -->
    <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
            <span class="material-icons-outlined">menu</span>
        </div>
        <div class="header-left">
            <span class="material-icons-outlined">search</span>
        </div>
        <div class="header-right">
            <span class="material-icons-outlined">notifications</span>
            <span class="material-icons-outlined">email</span>
            <span class="material-icons-outlined">account_circle</span>
        </div>
    </header>
    <!-- End Header -->

    <!-- Sidebar -->
    <aside id="sidebar">
        <div class="sidebar-title">
            <div class="sidebar-brand">
                <span class="material-icons-outlined"></span> CRS ADMIN
            </div>
        </div>

        <ul class="sidebar-list">
            <li class="sidebar-list-item">
                <a href="#" >
                    <span class="material-icons-outlined">dashboard</span> Dashboard
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="admin_prac.php" >
                    <span class="material-icons-outlined">groups</span> List of Reports
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="admin_panel.php" target="_blank">
                    <span class="material-icons-outlined">groups</span> Reports
                </a>
            </li>
            <li class="sidebar-list-item">
                <a href="#" target="_blank">
                    <span class="material-icons-outlined">settings</span> Settings
                </a>
            </li>
        </ul>
    </aside>
    <!-- End Sidebar -->

    <!-- Main -->
    <main class="main-container">
        <div class="main-title">
            <h2>DASHBOARD</h2>
        </div>

        <div class="main-cards">
            <div class="card">
                <div class="card-inner">
                    <h3>TOTAL CASES REPORTED</h3>
                    <span class="material-icons-outlined">reports</span>
                </div>
                <h1><?php echo $total_cases; ?></h1>
            </div>
            <!-- Other cards here -->
        </div>

        <div class="charts">
            <div class="charts-card">
                <h2 class="chart-title">Cases This month</h2>
                <div id="bar-chart"></div>
            </div>
            <div class="charts-card">
                <h2 class="chart-title">Graph of cases</h2>
                <div id="area-chart"></div>
            </div>
        </div>
    </main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
<!-- Custom JS -->
<script src="../js/dash_scripts.js"></script>
</body>
</html>
