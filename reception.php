<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receptionist Dashboard</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for better appearance */
        body {
            padding: 20px;
        }
        .patient-search {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
        }
        .patient-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
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
                    <a class="nav-link" href="#">Receptionist Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="new_appointment.php">New Appointments</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="time_slots.php">Timetable</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h1 class="mt-5">Receptionist Dashboard</h1>

        <div class="row mt-4">
            <div class="col-md-4">
                <!-- Patient Search Form -->
                <div class="patient-search">
                    <h2>Patient Search</h2>
                    <form id="patientSearchForm">
                        <div class="form-group">
                            <label for="patientName">Patient Name</label>
                            <input type="text" class="form-control" id="patientName" placeholder="Enter patient name" required>
                        </div>
                       <div class="form-group">
                            <label for="patientPhone">Patient Phone Number</label>
                            <input type="text" class="form-control" id="patientPhone" placeholder="Enter patient phone number" required>
                        </div>

                        <button type="submit" class="btn btn-primary">Search</button>
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <!-- Patient Information -->
                <div class="patient-info">
                    <h2>Patient Information</h2>
                    <div id="patientInfo">
                        <!-- Patient information will be displayed here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
       // Handle patient search form submission
$("#patientSearchForm").submit(function (event) {
    event.preventDefault();
    const patientName = $("#patientName").val();
    const patientPhone = $("#patientPhone").val(); // Add this line to get the phone number

    // Send an AJAX request to fetch patient data
    $.ajax({
        type: "POST",
        url: "backend/fetch_patient.php", // PHP endpoint to fetch patient data
        data: { patientName: patientName, patientPhone: patientPhone }, // Include both name and phone
        dataType: "json",
        success: function (patient) {
            if (patient) {
                // Display patient information
                displayPatientInfo(patient);
            } else {
                alert("Patient not found.");
            }
        },
        error: function () {
            alert("Failed to fetch patient data.");
        }
    });
});

// Function to display patient information
function displayPatientInfo(patient) {
    const patientInfoDiv = $("#patientInfo");
    patientInfoDiv.empty();
    patientInfoDiv.append(`
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <td>${patient.name}</td>
            </tr>
            <tr>
                <th>Phone Number</th>
                <td>${patient.phoneNumber}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>${patient.appointment_date}</td>
            </tr>
            <tr> <!-- Display additional patient information -->
                <th>Tmie Slot</th>
                <td>${patient.selected_time_slot}</td>
            </tr>
            <tr>
                <th>Doctor Specialty</th>
                <td>${patient.doctor_specialty}</td>
            </tr>
            <tr>
                <th>Health Insurance</th>
                <td>${patient.health_insurance}</td>
            </tr>
        </table>
    `);
}
    </script>
</body>
</html>
