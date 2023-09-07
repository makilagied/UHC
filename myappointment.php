<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hospital Appointment System</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for better appearance */
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="index.html">Home</a>
        <a class="navbar-brand" href="appointment.html">Appointments</a>
    </nav>

    <div class="container">
        <h1 class="mt-5">Check Your Appointments</h1>
        
        <div class="row">
            <div class="col-md-6">
                <form id="appointmentForm" class="mt-4">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
                    </div>
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number or Email</label>
                        <input type="text" class="form-control" id="phoneNumber" placeholder="Enter your phone number or email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Check Appointments</button>
                </form>
            </div>
            <div class="col-md-6">
                <div id="appointmentsTable" style="display: none;">
                    <h2>Your Appointments</h2>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Date</th>
                                 <th>Time</th>

                                <th>Department</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Appointments will be displayed here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        // Handle form submission
        $("#appointmentForm").submit(function (event) {
            event.preventDefault();
            const name = $("#name").val();
            const phoneNumber = $("#phoneNumber").val();

            // Send an AJAX request to fetch appointment data
            $.ajax({
                type: "POST",
                url: "backend/fetch_appointments.php", // Update the URL to your PHP endpoint
                data: { name: name, phoneNumber: phoneNumber },
                dataType: "json",
                success: function (appointments) {
                    // Display the fetched appointments
                    displayAppointments(appointments);
                },
                error: function () {
                    alert("Failed to fetch appointment data.");
                }
            });
        });

        // Function to display appointments in the table
        function displayAppointments(appointments) {
            const tableBody = $("#appointmentsTable tbody");
            tableBody.empty();

            if (appointments.length === 0) {
                tableBody.append("<tr><td colspan='4'>No appointments found.</td></tr>");
            } else {
                appointments.forEach(appointment => {
                    const statusText = appointment.status;
                    const statusClass = appointment.approved === 1 ? "text-success" : "text-danger";

                    tableBody.append(`
                        <tr>
                            <td>${appointment.appointment_date}</td>
                            <td>${appointment.available_time}</td>
                            <td>${appointment.doctor_specialty}</td>
                            <td class="${statusClass}">${statusText}</td>
                            <td><button class="btn btn-danger" onclick="cancelAppointment(${appointment.id})">Cancel</button></td>
                        </tr>
                    `);
                });
            }

            // Show the table
            $("#appointmentsTable").show();
        }

        // Function to cancel an appointment (for demonstration purposes)
        function cancelAppointment(appointmentId) {
            // Here, you would implement the logic to cancel the appointment.
            // You might want to send a request to the server to update the database.

            // For this example, we'll simply remove the row from the table.
            const row = document.querySelector(`tr[data-appointment-id="${appointmentId}"]`);
            if (row) {
                row.remove();
            }
        }
    </script>
</body>
</html>
