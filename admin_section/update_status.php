<?php
// Check if the form is submitted and the report ID is provided
if (isset($_POST['report_id']) && isset($_POST['action'])) {
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

    $report_id = $_POST['report_id'];
    $action = $_POST['action']; // 'solve' or 'pending'

    // Update the status based on the action for the specific report ID
    $status = ($action == 'solve') ? 'Solved' : 'Pending';

    // Prepare and bind the SQL statement to prevent SQL injection
    $sql = "UPDATE report_crime SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $report_id);

    if ($stmt->execute()) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . $conn->error;
    }

    // Close statement and database connection
    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request";
}
?>
