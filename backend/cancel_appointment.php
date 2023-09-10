<?php
// Include your database connection code here
require_once('db.php');

// Check if the appointment ID is provided in the POST request
if (isset($_POST['appointmentId'])) {
    $appointmentId = $_POST['appointmentId'];

    // Implement the logic to delete the appointment from the database table
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $appointmentId);

    if ($stmt->execute()) {
        // Appointment deleted successfully
        $response = ['success' => true];
    } else {
        // Error deleting the appointment
        $response = ['success' => false];
    }

    // Send the JSON response
    header('Content-type: application/json');
    echo json_encode($response);
} else {
    // Invalid request
    header("HTTP/1.0 400 Bad Request");
}
?>
