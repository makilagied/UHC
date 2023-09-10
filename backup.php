<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Booking</title>
    <!-- Include necessary CSS and JavaScript libraries -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container">
        <h1>Book an Appointment</h1>
        <form id="appointmentForm" action="backend/appointmentForm.php" method="post">
            <div class="form-group">
                <label for="appointment_date">Select Date:</label>
                <input type="date" class="form-control" id="appointment_date" name="appointment_date" required>
            </div>
            <div class="form-group">
                <label for="doctor_specialty">Select Doctor Specialty:</label>
                <select class="form-control" id="doctor_specialty" name="doctor_specialty" required>
                    <option value="">Select a Doctor Specialty</option>
                    <!-- Options will be populated dynamically using JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="selected_time_slot">Select Time Slot:</label>
                <select class="form-control" id="selected_time_slot" name="selected_time_slot" required>
                    <option value="">Select a Time Slot</option>
                    <!-- Options will be populated dynamically using JavaScript -->
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Book Appointment</button>
        </form>
    </div>

    <script>
        // JavaScript code to dynamically load doctor specialties and time slots
        document.addEventListener("DOMContentLoaded", function () {
            const doctorSpecialtySelect = document.getElementById("doctor_specialty");
            const timeSlotSelect = document.getElementById("selected_time_slot");
            const appointmentDateInput = document.getElementById("appointment_date");

            // Function to load doctor specialties
            function loadDoctorSpecialties() {
                $.ajax({
                    type: "GET",
                    url: "backend/getDoctorSpecialties.php",
                    dataType: "json",
                    success: function (data) {
                        // Clear existing options
                        doctorSpecialtySelect.innerHTML = "<option value=''>Select a Doctor Specialty</option>";

                        // Populate 'doctorSpecialtySelect' with fetched data
                        data.specialties.forEach(specialty => {
                            const option = document.createElement("option");
                            option.value = specialty;
                            option.textContent = specialty;
                            doctorSpecialtySelect.appendChild(option);
                        });

                        // Trigger the change event to load time slots based on the initial date
                        doctorSpecialtySelect.dispatchEvent(new Event("change"));
                    },
                    error: function (xhr, status, error) {
                        console.error("An error occurred:", error);
                    }
                });
            }

            // Function to load time slots based on selected date and specialty
            function loadTimeSlots() {
                const selectedSpecialty = doctorSpecialtySelect.value;
                const selectedDate = appointmentDateInput.value;

                // Check if both specialty and date are selected
                if (selectedSpecialty && selectedDate) {
                    $.ajax({
                        type: "GET",
                        url: "backend/getTimeSlots.php",
                        data: {
                            specialty: selectedSpecialty,
                            date: selectedDate
                        },
                        dataType: "json",
                        success: function (data) {
                            // Clear existing options
                            timeSlotSelect.innerHTML = "<option value=''>Select a Time Slot</option>";

                            // Populate 'timeSlotSelect' with fetched data
                            data.timeSlots.forEach(slot => {
                                const option = document.createElement("option");
                                option.value = slot;
                                option.textContent = slot;
                                timeSlotSelect.appendChild(option);
                            });
                        },
                        error: function (xhr, status, error) {
                            console.error("An error occurred:", error);
                        }
                    });
                } else {
                    // Clear the 'selected_time_slot' dropdown if specialty or date is not selected
                    timeSlotSelect.innerHTML = "<option value=''>Select a Time Slot</option>";
                }
            }

            // Attach change event listener to the doctor specialty dropdown
            doctorSpecialtySelect.addEventListener("change", function () {
                // Load time slots based on the selected specialty
                loadTimeSlots();
            });

            // Attach change event listener to the appointment date input
            appointmentDateInput.addEventListener("change", function () {
                // Load time slots based on the selected date
                loadTimeSlots();
            });

            // Load doctor specialties when the page loads
            loadDoctorSpecialties();
        });
    </script>
</body>
</html>
