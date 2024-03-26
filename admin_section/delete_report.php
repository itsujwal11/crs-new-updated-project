<?php
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

// Check if delete button is clicked
if(isset($_POST['delete_btn'])) {
    // Check if report_id is set and not empty
    if(isset($_POST['report_id']) && !empty($_POST['report_id'])) {
        $report_id = $_POST['report_id'];

        // Construct the SQL DELETE query
        $sql = "DELETE FROM report_crime WHERE id = $report_id";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            echo "Record deleted successfully";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Report ID not provided";
    }
} else {
    echo "Delete button not clicked"; // Debug statement to check if the delete button is clicked
}

// Close database connection
$conn->close();
?>
