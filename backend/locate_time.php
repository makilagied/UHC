<?php
// Include your database connection code here (backend/db.php)
require_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize the form data
    $doctorId = $_POST['doctor'];
    $date = $_POST['date'];
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];

    // Perform the allocation of time slot and insert data into the 'time_slots' table
    $sql = "INSERT INTO time_slots (doctor_id, date, start_time, end_time) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $doctorId, $date, $start_time, $end_time);

    $response = array();
    if ($stmt->execute()) {
        $response["success"] = true;
        $response["message"] = "Time slot allocated successfully.";
    } else {
        $response["success"] = false;
        $response["message"] = "Error allocating time slot: " . $conn->error;
    }

    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
