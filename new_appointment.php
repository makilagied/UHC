<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Appointments</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for better appearance */
        body {
            background-color: #f4f4f4;
            padding: 20px;
        }
        .appointment-list {
            background-color: #ffffff;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }
        .table th {
            background-color: #f8f9fa;
        }
        .btn-approve {
            background-color: #28a745;
            color: #fff;
        }
        .btn-approve:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Hospital Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">New Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reception.php">Receptionist Dashboard </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="time_slots.php">Timetable</a>
                </li>
            </ul>
            </ul>
        </div>
    </nav>
        <h1 class="mt-5">New Appointments</h1>

        <div class="appointment-list mt-4">
            <h2>Appointment List</h2>
            <?php
         require_once('backend/db.php'); // Include the database connection file

            // Query to retrieve appointment data
            $sql = "SELECT * FROM appointments WHERE approved = 0"; // Add WHERE clause to filter unapproved appointments
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                echo '<div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Doctor Specialty</th>
                                    <th>Patient Name</th>
                                    <th>Phone</th>
                                    <th>Location</th>
                                    <th>Health Insurance</th>
                                    <th>Health Status Description</th>
                                    <th>Appointment Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>
                            <td>' . $row["doctor_specialty"] . '</td>
                            <td>' . $row["patient_name"] . '</td>
                            <td>' . $row["phone"] . '</td>
                            <td>' . $row["health_insurance"] . '</td>
                            <td>' . $row["health_status_description"] . '</td>
                            <td>' . $row["appointment_date"] . '</td>
                            <td>' . $row["selected_time_slot"] . '</td>
                            <td>
                            <button class="btn btn-approve btn-sm" onclick="approveAppointment('.$row["id"].')">Approve</button>
                            </td>
                        </tr>';
                }

                echo '</tbody></table></div>';
            } else {
                echo "<p>No appointments found.</p>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
function approveAppointment(appointmentId) {
    // Send a request to mark the appointment as approved
    $.ajax({
        type: "POST",
        url: "backend/approve_appointment.php",
        data: {
            appointmentId: appointmentId
        },
        success: function(response) {
            if (response === "success") {
                alert("Appointment marked as approved.");
                location.reload(); // Refresh the page to reflect changes
            } else {
                alert("Failed to mark appointment as approved.");
            }
        }
    });
}
</script>

</body>
</html>
