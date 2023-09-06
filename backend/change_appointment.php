<?php
// Include your database connection setup here

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointmentId = $_POST["appointmentId"];
    $newTimeSlot = $_POST["newTimeSlot"];

    // Validate and sanitize the input data as needed

    // Update the appointment in the database with the new time slot
    $sql = "UPDATE appointments SET appointment_date = '$newTimeSlot' WHERE id = $appointmentId";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "error";
    }
} else {
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
