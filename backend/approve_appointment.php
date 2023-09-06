<?php
require_once('db.php'); // Include the database connection file

// Include your database connection setup here

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $appointmentId = $_POST["appointmentId"];

    // Update the appointment in the database to mark it as approved
    $sql = "UPDATE appointments SET approved = 1 WHERE id = $appointmentId";

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
