<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS styles */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        /* Hide the chart section by default */
        #chartSection {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Doctor Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="showChart">Analysis</a>
                    </li>
                    <!-- Add the "Print Reports" menu item -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="printReports">Print Reports</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="backend/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        
        <!-- Display Doctor's Name and Department -->
        <?php
        // Check if a doctor is logged in (using sessions)
        if (isset($_SESSION['doctor_id'])) {
            // Fetch doctor's name and specialty from the doctors table based on session doctor_id
            $doctor_id = $_SESSION['doctor_id'];
            require_once('backend/db.php'); // Include the database connection file
            $doctor_info_query = "SELECT name, specialty FROM doctors WHERE id = $doctor_id";
            $doctor_info_result = $conn->query($doctor_info_query);

            if ($doctor_info_result && $doctor_info_result->num_rows > 0) {
                $row = $doctor_info_result->fetch_assoc();
                $doctor_name = strtoupper($row['name']); // Convert the name to uppercase
                $doctor_specialty = $row['specialty'];

                echo '<h2 class="mt-4">Welcome, ' . $doctor_name . '</h2>';
                echo '<p>Department: ' . $doctor_specialty . '</p>';
            } else {
                echo "Error fetching doctor's information.";
            }

            // $conn->close();
        } else {
            header("Location: login.php"); 
        }
        ?>

        <!-- Patient Info Table -->
        <h2 class="mt-4">Patient Information</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Patient Name</th>
                    <th>Phone</th>
                    <th>Health Insurance</th>
                    <th>Health Status</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                <!-- PHP code for fetching and displaying patient data here -->
                <?php
                // Check if a doctor is logged in (using sessions)
                if (isset($_SESSION['doctor_id'])) {
                    // Fetch doctor's specialty from the doctors table based on session doctor_id
                    $doctor_id = $_SESSION['doctor_id'];
                    $doctor_specialty_query = "SELECT specialty FROM doctors WHERE id = $doctor_id";
                    $specialty_result = $conn->query($doctor_specialty_query);
                    if ($specialty_result && $specialty_result->num_rows > 0) {
                        $row = $specialty_result->fetch_assoc();
                        $doctor_specialty = $row['specialty'];

                        // Fetch patient data and appointment dates from the database based on doctor's specialty
                        $sql = "SELECT * FROM appointments WHERE doctor_specialty = '$doctor_specialty' AND approved=1";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            // Output the patient data in a table
                            $count = 1; // Initialize the count
                            while ($row = $result->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td>' . $count . '</td>'; // Display the count
                                echo '<td>' . $row['patient_name'] . '</td>';
                                echo '<td>' . $row['phone'] . '</td>';
                                echo '<td>' . $row['health_insurance'] . '</td>';
                                echo '<td>' . $row['health_status_description'] . '</td>';
                                echo '<td>' . $row['appointment_date'] . '</td>';
                                echo '<td>' . $row['selected_time_slot'] . '</td>';
                                echo '</tr>';
                                $count++; // Increment the count for the next row
                            }
                        } else {
                            echo "No patient data found for your specialty.";
                        }
                    } else {
                        echo "Error fetching doctor's specialty.";
                    }
                } else {
                    echo "You are not logged in as a doctor.";
                }
                ?>
            </tbody>
        </table>

        <!-- Charts and Reports Section -->
        <div id="chartSection" class="mt-4">
            <h2>Reports and Analysis</h2>
            <!-- Include Chart.js library -->
            <canvas id="patientAnalysisChart" width="400" height="200"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                // Custom JavaScript for chart setup
                var ctx = document.getElementById('patientAnalysisChart').getContext('2d');
                var patientAnalysisChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                        datasets: [{
                            label: 'Patient Visits',
                            data: [10, 15, 8, 12, 18],
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            </script>
        </div>
    </div>

    <!-- Include Bootstrap and jQuery JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Show the chart section when "Analysis" menu item is clicked
        document.getElementById('showChart').addEventListener('click', function() {
            document.getElementById('chartSection').style.display = 'block';
        });
    </script>
    <!-- Include the JavaScript code at the end of the page -->
    <script>
        // Show the chart section when "Analysis" menu item is clicked
        document.getElementById('showChart').addEventListener('click', function() {
            document.getElementById('chartSection').style.display = 'block';
        });

        // Print the reports when "Print Reports" menu item is clicked
        document.getElementById('printReports').addEventListener('click', function() {
            // Open the print dialog
            window.print();
        });
    </script>
</body>
</html>
