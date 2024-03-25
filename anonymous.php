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

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $report_type = $_POST["report-type"];
  $description = $_POST["description"];
  
  // Prepare and execute SQL statement
  $sql = "INSERT INTO anonymous_reports (report_type, description) VALUES (?, ?)";
  $stmt = $conn->prepare($sql);
  
  // Check if statement preparation was successful
  if ($stmt) {
    $stmt->bind_param("ss", $report_type, $description); // ss indicates two string parameters
    if ($stmt->execute()) {
      echo "Report submitted successfully!";
    } else {
      echo "Error: " . $stmt->error;
    }
    // Close statement
    $stmt->close();
  } else {
    echo "Error: " . $conn->error;
  }
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!----======== CSS ======== -->
    <link rel="stylesheet" href="anonymous.css">
     
    <!----===== Iconscout CSS ===== -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Admin Dashboard Panel</title>
</head>
<body>
    <div class="anonymous-reporting">
            <div class="title">
                <i class="uil uil-thumbs-up"></i>
                <span class="text">Anonymous Reporting</span>
            </div>
            <form class="report-form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <label for="report-type">Type of Incident:</label>
                <select id="report-type" name="report-type">
                    <option value="assault">Assault</option>
                    <option value="theft">Theft</option>
                    <option value="scam">Scam</option>
                    <option value="vandalism">Vandalism</option>
                </select>

                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="4" required></textarea>

                <button type="submit">Submit Report</button>
            </form>
        </div>



</body>
</html>
