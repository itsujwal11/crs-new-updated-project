<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../admin_section/admin_panel.css">
</head>
<body>
    <!-- Sidebar -->
<!-- Main Content -->
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
                    <th>Action</th> <!-- New column for delete button -->
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
                $sql = "SELECT * FROM report_crime";
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
                        // Add delete button
                        echo "<td>
                        <form method='post' action='delete_report.php'>
                            <input type='hidden' name='report_id' value='" . $row['id'] . "'>
                            <button type='submit' name='delete_btn'>Delete</button>
                        </form>
                    </td>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No reported crimes found.</td></tr>";
                }

                // Close database connection
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
