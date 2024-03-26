<?php
// Define a variable to hold the message
$message = "";

// Database connection
$servername = "localhost"; // Change this if your MySQL server is running on a different host
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "login";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Form submission handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $report_type = $_POST["report-type"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $description = $_POST["description"];

    // Insert data into the database
    $sql = "INSERT INTO report_crime (report_type, name, phone, address, description)
    VALUES ('$report_type', '$name', '$phone', '$address', '$description')";

    if ($conn->query($sql) === TRUE) {
        $message = "Report submitted successfully";
    } else {
        $message = "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" href="reporting.css">
    <!-- Iconscout CSS -->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Admin Dashboard Panel</title>
</head>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
               <img src="images/logo.png" alt="">
            </div>

            <span class="logo_name">CRS</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="dashboard.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dashboard</span>
                </a></li>
                <li><a href="report_form.php">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Report Crime</span>
                </a></li>
                <li><a href="view_status.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">View Status</span>
                </a></li>
            
                <li><a href="contact.php">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Contact us</span>
                </a></li>
          
            </ul>
            
            <ul class="logout-mode">
                <li><a href="logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="logout">Logout</span>
                </a></li>

             

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>
    <div class="anonymous-reporting">
        <div class="title">
            <i class="uil uil-thumbs-up"></i>
            <span class="text">Report Your Problem</span>
        </div>
        
        <!-- Display the message -->
        <div id="message"><?php echo $message; ?></div>
        
        <form class="report-form" id="reportForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <label for="report-type">Type of Incident:</label>
            <select id="report-type" name="report-type">
                <option value="assault">Assault</option>
                <option value="theft">Theft</option>
                <option value="scam">Scam</option>
                <option value="vandalism">Vandalism</option>
            </select>

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="phone">Phone Number:</label>
            <input type="number" id="phone" name="phone" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="4" required></textarea>

            <button type="submit" id="submitButton">Submit Report</button>
        </form>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('reportForm');
        const messageDiv = document.getElementById('message');

        form.addEventListener('submit', function(event) {
            // Prevent the form from submitting normally
            event.preventDefault();

            // Perform Ajax request or submit the form data using fetch or XMLHttpRequest
            // For now, we'll just display an alert message
            messageDiv.textContent = "Report submitted successfully!";
            messageDiv.style.color = "green";
            
            // Clear the message after 3 seconds
            setTimeout(function() {
                messageDiv.textContent = "";
            }, 3000);
        });
    });
</script>
</body>
</html>