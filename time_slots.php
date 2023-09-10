<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Allocate Time Slots</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom CSS for better appearance */
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
        }
        .card {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            margin: 10px;
            width: 100%;
        }
        .card-header {
            font-weight: bold;
        }
        select, input[type="date"], input[type="time"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        /* Style for the timetable table */
        #timetable {
            width: 100%;
        }
        /* Media query for desktop view */
        @media (min-width: 768px) {
            .container {
                display: inline-flex;
                flex-wrap: nowrap;
                justify-content: space-between;
            }
            .card {
                width: 48%; /* Adjust the width as needed */
            }
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Hospital Dashboard</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Timetable</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="reception.php">Receptionist Dashboard </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="new_appointment.php">New Appointment</a>
                </li>
            </ul>
            </ul>
        </div>
    </nav>
    <div class="container">
        <!-- Timetable Entry Section -->
        <div class="card">
            <div class="card-header">
                <h2>Timetable Entry</h2>
            </div>
            <div class="card-body">
                <form method="POST" action="backend/locate_time.php">
                    <div class="form-group">
                        <label for="doctor">Doctor:</label>
                        <select class="form-control" name="doctor" id="doctor">
                            <!-- Populate this dropdown with doctor names from the 'doctors' table -->
                            <?php
                            // Include your database connection code here
                            require_once('backend/db.php');
                            // Fetch doctor names from the 'doctors' table
                            $sql = "SELECT id, name FROM doctors";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="date">Date:</label>
                        <input class="form-control" type="date" name="date" id="date" required>
                    </div>

                    <div class="form-group">
                        <label for="start_time">Start Time:</label>
                        <input class="form-control" type="time" name="start_time" id="start_time" required>
                    </div>

                    <div class="form-group">
                        <label for="end_time">End Time:</label>
                        <input class="form-control" type="time" name="end_time" id="end_time" required>
                    </div>

                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="Allocate">
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter Timetable Section -->
        <div class="card">
            <div class="card-header">
                <h2>Filter Timetable</h2>
            </div>
            <div class="card-body">
                <form id="filterForm" method="GET" action="#">
                    <div class="form-group">
                        <label for="filterDoctor">Filter by Doctor:</label>
                        <select class="form-control" name="filterDoctor" id="filterDoctor">
                            <option value="">All Doctors</option>
                            <!-- Populate this dropdown with doctor names from the 'doctors' table -->
                            <?php
                            // Fetch doctor names from the 'doctors' table
                            $sql = "SELECT id, name FROM doctors";
                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<option value='{$row['id']}'>{$row['name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="filterDate">Filter by Date:</label>
                        <input class="form-control" type="date" name="filterDate" id="filterDate">
                    </div>
                    <input class="btn btn-primary" type="submit" value="Filter">
                </form>

                <div id="timetable">
                    <h2>Doctor's Timetable</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Doctor</th>
                                <th>Day</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include your database connection code here
                            require_once('backend/db.php');

                            // Fetch doctor's timetable from the 'time_slots' table
                            $sql = "SELECT doctors.name AS doctor_name, time_slots.date, time_slots.start_time, time_slots.end_time
                                    FROM time_slots
                                    INNER JOIN doctors ON time_slots.doctor_id = doctors.id
                                    ORDER BY time_slots.date DESC";

                            $result = $conn->query($sql);

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row['doctor_name'] . '</td>';
                                    echo '<td>' . $row['date'] . '</td>';
                                    echo '<td>' . $row['start_time'] . '</td>';
                                    echo '<td>' . $row['end_time'] . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4">No timetable available.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Include this JavaScript code in your time_slots.php file -->
    <script>
        // JavaScript to handle form submission
        document.querySelector("form").addEventListener("submit", function (event) {
            event.preventDefault();
            const formData = new FormData(this);

            // Send an AJAX request to the PHP script
            fetch("backend/locate_time.php", {
                method: "POST",
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Time slot allocated successfully
                    alert(data.message);
                    // You can perform additional actions here if needed
                } else {
                    // Error allocating time slot
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("An error occurred:", error);
                alert("An error occurred. Please try again later.");
            });
        });
    </script>

    <!-- Add this JavaScript code inside the <script> section of your time_slots.php file -->
<script>
// JavaScript to handle filter form submission
document.getElementById("filterForm").addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(this);

    // Construct the URL with query parameters
    const url = "backend/filter_timetable.php?" + new URLSearchParams(formData).toString();

    // Send a GET request to the filter_timetable.php script
    fetch(url)
    .then(response => response.text())
    .then(data => {
        console.log("Data received:", data);
        // Update the 'timetable' div with the filtered data
        document.getElementById("timetable").innerHTML = data;
    })
    .catch(error => {
        console.error("An error occurred:", error);
        alert("An error occurred. Please try again later.");
    });
});
</script>

</body>
</html>
