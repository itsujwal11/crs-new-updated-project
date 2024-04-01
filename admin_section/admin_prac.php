<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">
    <link rel="stylesheet" href="../admin_css/admin_prac.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


</head>
<body>
    <div class="grid-container">
    
            <div class="menu-icon" onclick="openSidebar()">
               
            </div>
    
            <aside id="sidebar">
  <div class="sidebar_title">
    <h3>CRS ADMIN</h3>

        </div>

        <ul class="sidebar-list">
            <li class="sidebar-list-item">
                <a href="admin_dashboard.php" >
                    <span class="material-icons-outlined">dashboard</span> Dashboard
                </a>
            </li>
            <li class="sidebar-list-item">
    <a href="admin_prac.php">
        <span class="material-icons-outlined">groups</span> 
        <span>List of Reports</span>
    </a>
</li>
<li class="sidebar-list-item">
                    <a href="archive_report.php">
                        <span class="material-icons-outlined">archive</span> Archived Reports
                    </a>
                </li>
         
           
        </ul>
        <ul class="logout-mode">
                <li><a href="../logout.php">
             
                    <span class="logout">Logout</span>
                </a></li>

    </aside>
<style>
/* CSS for logout link */
.logout-mode {
    list-style-type: none;
    padding: auto;
margin: 5px;
margin-top: 155%;
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


.toggle-actions-btn {
      display: flex;
      gap: 5px;
  }

  .toggle-actions-btn button {
      padding: 6px 10px;
      border-radius: 5px;
      cursor: pointer;
  }

  .toggle-actions-btn button:hover {
      background-color: #ddd;
  }

  .toggle-actions-btn .toggle-btn {
      background-color: #007bff;
      color: #fff;
      border: none;
  }

  .toggle-actions-btn .solve-btn {
      background-color: #28a745;
      color: #fff;
      border: none;
  }

  .toggle-actions-btn .delete-btn {
      background-color: #dc3545;
      color: #fff;
      border: none;
  }

  table {
        width: 100%;
        border-collapse: collapse;
        border-spacing: 0;

    }
    th, td {
        padding: 15px;
        text-align: left;
    border: 1px solid black;
    }
    th {
        background-color: #f2f2f2;
        border: 1px solid black;
    }
    tr:hover {
        background-color: #f5f5f5;
    }

    .container{
        margin-top: -300px;
padding: 400px;

    }
</style>
        <div class="main-content">
           
            <div class="container">
                <h2>Reported Crimes</h2>
               
                <table>
                    <thead>
                        <tr>
                            <th>Submission Date</th>
                            <th>Report Type</th>
                            <th>Address</th>
                            <th>View More</th>
                            <th>Verified</th>
                            <th>Actions</th>
                            <th>Solved Cases</th>
                            <th>Archive</th>
                        </tr>
                    </thead>
                    <tbody>
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

                        // Fetch reported crimes data
                        $sql = "SELECT *, (SELECT COUNT(*) FROM report_crime AS rc2 WHERE rc2.status = 'Solved' AND rc2.id = report_crime.id) AS solved_cases FROM report_crime";
                        $result = $conn->query($sql);

                        // Display data in the table
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['submission_date'] . "</td>";
                                echo "<td>" . $row['report_type'] . "</td>";
                                echo "<td>" . $row['address'] . "</td>";
                               
                              

                                  // View More button
                                  echo "<td>";
                                  echo "<button class='view-more-btn btn btn-primary' data-toggle='modal' data-target='#exampleModal' data-details='" . htmlentities(json_encode($row)) . "'>View More</button>";
                                  echo "</td>";
                                echo "<td>" . $row['verified'] . "</td>"; // Display verified status
                                
                                // Actions column
                                echo "<td class='toggle-actions-btn'>";
                                echo "<form method='post' action='toggle_verification.php' onsubmit='showAlert(\"Verification status toggled successfully\")'>
                                            <input type='hidden' name='report_id' value='" . $row['id'] . "'>
                                            <button class='toggle-btn' type='submit' name='toggle_btn'><span class='material-icons-outlined'>sync_alt</span></button>
                                        </form>";
                                echo "<form method='post' action='update_status.php'>
                                            <input type='hidden' name='report_id' value='" . $row['id'] . "'>
                                            <button class='solve-btn' type='submit' name='action' value='solve'><span class='material-icons-outlined'>done</span></button>
                                        </form>";
                                echo "</td>";
                                
                                echo "<td>" . $row['solved_cases'] . "</td>"; // Display the number of solved cases
                                
                                // Archive button
                                echo "<td>
                                <form method='post' action='archive_process.php' onsubmit='return confirm(\"Are you sure you want to archive this report?\")'>
                                    <input type='hidden' name='report_id' value='" . $row['id'] . "'>
                                    <a href='archive_report.php?id=$row[id]' class='archive-btn' name='archive_btn'><span class='material-icons-outlined'>archive</span></a>
                                </form>
                            </td>";

                                echo "</tr>";
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
    </div>

 
    <!-- Bootstrap Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">More Details</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
    <table class="table">
    <thead>
                        <tr>
                            <th>name</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Video</th>
                        </tr>
                    </thead>
    </table>
    <div id="image-container"></div>
</div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // JavaScript code to populate modal with details
        document.addEventListener('DOMContentLoaded', function () {
            const viewMoreBtns = document.querySelectorAll('.view-more-btn');
            viewMoreBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    const details = JSON.parse(this.dataset.details);
                    populateModal(details);
                });
            });

            function populateModal(details) {
                // Populate modal with data
                document.getElementById('name').textContent = details['name'];
                document.getElementById('description').textContent = details['description'];

                // Display image
                const imageContainer = document.getElementById('image-container');
                const image = document.createElement('img');
                image.src = `data:image/jpeg;base64,${details['image']}`; // Assuming images are in JPEG format
                image.style.maxWidth = '100%'; // Adjust image width if needed
                imageContainer.innerHTML = ''; // Clear previous content
                imageContainer.appendChild(image);

                // Add more details here if needed
            }

            // JavaScript code to store table data in an array
            const tableBody = document.querySelector('tbody');
            let tableData = [];

            tableBody.querySelectorAll('tr').forEach(row => {
                let rowData = {};
                const cells = row.querySelectorAll('td');

                rowData['Submission Date'] = cells[0].textContent;
                rowData['Report Type'] = cells[1].textContent;
                rowData['Address'] = cells[2].textContent;
                rowData['View More'] = cells[3].textContent;
                rowData['Verified'] = cells[4].textContent;
                rowData['Actions'] = cells[5].textContent;
                rowData['Solved Cases'] = cells[6].textContent;
                rowData['Archive'] = cells[7].textContent;

                tableData.push(rowData);
            });

            console.log(tableData);
        });
    </script>
</body>
</html>
