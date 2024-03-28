<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="admin_prac.css">
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head>
<body>
    <div class="grid-container">
        <header class="header">
            <div class="menu-icon" onclick="openSidebar()">
                <span class="material-icons-outlined">menu</span>
            </div>
           
        </header>
        <aside id="sidebar">
            <div class="sidebar-title">
                <div class="sidebar-brand">
                    <span class="material-icons-outlined"></span> CRS ADMIN
                </div>
                <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
            </div>
            <ul class="sidebar-list">
                <li class="sidebar-list-item">
                    <a href="admin_dashboard.php" >
                        <span class="material-icons-outlined">dashboard</span> Dashboard
                    </a>
                </li>
                
                <ul class="logout-mode">
                <li><a href="../logout.php">
             
                    <span class="logout">Logout</span>
                </a></li>
            </ul>
        </aside>

        <style>
/* CSS for logout link */
.logout-mode {
    list-style-type: none;
    padding: auto;
margin: 5px;
margin-top: 180%;
}

.logout-mode li {
    display: inline-block;
    margin-right: 10px;
}

.logout-mode li a {
    text-decoration: none;
    color: white;
    font-weight: bold;
    padding: 8px 16px; /* Adjust padding as needed */
    border: 1px solid white; /* Border style */
    border-radius: 5px; /* Rounded corners */
    transition: all 0.3s; /* Smooth transition */
}

.logout-mode li a:hover {
    background-color: red; /* Background color on hover */
    color: #fff; /* Text color on hover */
}


</style>

        <div class="main-content">
            <div class="header">
                <h1>Dashboard</h1>
                <!-- Add header content or navigation here -->
            </div>
            <div class="container">
                <!-- Reported Crimes Table -->
                <h2>Reported Crimes</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Report Type</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Description</th>
                            <th>Submission Date</th>
                            <th>Verified</th> <!-- New column for verified status -->
                            <th>Toggle Verification</th> <!-- New column for toggle button -->
                            <th>Action</th> <!-- New column for solve button -->
                            <th>Solved Cases</th> <!-- New column for displaying solved cases count -->
                            <th>Delete</th> <!-- New column for delete button -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // PHP code to fetch and display reported crimes will go here
                        // Database connection
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $database = "login";
        
                        $conn = new mysqli($servername, $username, $password, $database);
        
                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }
        
                        // Fetch reported crimes data
                        $sql = "SELECT *, (SELECT COUNT(*) FROM report_crime AS rc2 WHERE rc2.status = 'Solved' AND rc2.id = report_crime.id) AS solved_cases FROM report_crime";
                        $result = $conn->query($sql);
        
                        // Display data in the table
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td>" . $row['report_type'] . "</td>";
                                echo "<td>" . $row['name'] . "</td>";
                                echo "<td>" . $row['phone'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                                echo "<td>" . $row['submission_date'] . "</td>";
                                echo "<td>" . $row['verified'] . "</td>"; // Display verified status
                                // Add toggle button to toggle the status
                                echo "<td>
                                        <form method='post' action='toggle_verification.php' onsubmit='showAlert(\"Verification status toggled successfully\")'>
                                            <input type='hidden' name='report_id' value='" . $row['id'] . "'>
                                            <button type='submit' name='toggle_btn'>Toggle</button>
                                        </form>
                                    </td>";
                                // Add form for marking as solved
                                echo "<td>
                                        <form method='post' action='update_status.php'>
                                            <input type='hidden' name='report_id' value='" . $row['id'] . "'>
                                            <button type='submit' name='action' value='solve'>Solve</button>
                                        </form>
                                    </td>";
                                // Display the number of solved cases
                                echo "<td>" . $row['solved_cases'] . "</td>";
                                // Add delete button with form
                                echo "<td>
                                        <form method='post' action='delete_report.php' onsubmit='return confirm(\"Are you sure you want to delete this report?\")'>
                                            <input type='hidden' name='report_id' value='" . $row['id'] . "'>
                                            <button type='submit' name='delete_btn'>Delete</button>
                                        </form>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='12'>No reported crimes found.</td></tr>";
                        }
        
                        // Close database connection
                        $conn->close();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <script src="script.js"></script>
</body>
</html>
