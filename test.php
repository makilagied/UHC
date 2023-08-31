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
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
        
        <!-- Patient Info Table -->
        <h2 class="mt-4">Patient Information</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Patient Name</th>
                    <th>Phone</th>
                    <th>Location</th>
                    <th>Health Insurance</th>
                    <th>Health Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            <?php


// Database connection settings
$servername = "localhost";
$username = "root";
$password = "Bee19Knee's99";
$dbname = "UHC"; // Replace with your database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

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
        $sql = "SELECT patient_name, phone, location, health_insurance, health_status_description, appointment_date FROM appointments WHERE doctor_specialty = '$doctor_specialty'";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            // Output the patient data in a table
            $count = 1; // Initialize the count
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . $count . '</td>'; // Display the count
                echo '<td>' . $row['patient_name'] . '</td>';
                echo '<td>' . $row['phone'] . '</td>';
                echo '<td>' . $row['location'] . '</td>';
                echo '<td>' . $row['health_insurance'] . '</td>';
                echo '<td>' . $row['health_status_description'] . '</td>';
                echo '<td>' . $row['appointment_date'] . '</td>';
                echo '</tr>';
                $count++; // Increment the count for the next row
            }
            echo '</table>';
        } else {
            echo "No patient data found for your specialty.";
        }
    } else {
        echo "Error fetching doctor's specialty.";
    }
} else {
    echo "You are not logged in as a doctor.";
}

$conn->close();
?>


            </tbody>
        </table>

        <!-- Charts and Reports Section -->
        <div class="mt-4">
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
</body>
</html>
