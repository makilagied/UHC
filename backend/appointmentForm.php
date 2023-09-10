<?php
require_once('db.php'); // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize user inputs (to prevent SQL injection)
    $full_name = mysqli_real_escape_string($conn, $_POST["patient_name"]);
    $phone_number = mysqli_real_escape_string($conn, $_POST["phone"]);
    $location = mysqli_real_escape_string($conn, $_POST["location"]);
    $health_insurance = mysqli_real_escape_string($conn, $_POST["health_insurance"]);
    $health_status_description = mysqli_real_escape_string($conn, $_POST["health_status"]);
    $appointment_date = mysqli_real_escape_string($conn, $_POST["appointment_date"]);
    $department = mysqli_real_escape_string($conn, $_POST["doctor_specialty"]);
    $selected_time_slot = mysqli_real_escape_string($conn, $_POST["selected_time_slot"]); // Add this line to get the selected time slot
// Extract the first 8 characters of the selected time slot
    $selected_time_slot = substr(mysqli_real_escape_string($conn, $_POST["selected_time_slot"]), 0, 8);

    // SQL query to insert the form data into the 'appointments' table
    $sql = "INSERT INTO appointments (doctor_specialty, patient_name, phone, location, health_insurance, health_status_description, appointment_date, selected_time_slot)
            VALUES ('$department', '$full_name', '$phone_number', '$location', '$health_insurance', '$health_status_description', '$appointment_date', '$selected_time_slot')";

    if ($conn->query($sql) === TRUE) {
        // Mark the selected time slot as not available in the 'time_slots' table
        $updateSql = "UPDATE time_slots SET is_available = 0 WHERE date = '$appointment_date' AND doctor_id = (SELECT id FROM doctors WHERE specialty = '$department') AND start_time = '$selected_time_slot'";
        if ($conn->query($updateSql) === TRUE) {
            // Redirect to myappointment.php on success
            header("Location: ../myappointment.php");
            exit(); // Make sure to exit to prevent further script execution
        } else {
            echo "Error updating time slot: " . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
