<?php
// Include your database connection code here
require_once('db.php');

// Check if the patientName or patientPhone parameter is provided via POST
if (isset($_POST['patientName']) || isset($_POST['patientPhone'])) {
    $patientName = isset($_POST['patientName']) ? $_POST['patientName'] : '';
    $patientPhone = isset($_POST['patientPhone']) ? $_POST['patientPhone'] : '';

    // Perform a database query to fetch patient data by name or phone number
    $sql = "SELECT DISTINCT patient_name AS name, phone AS phoneNumber, selected_time_slot,appointment_date, doctor_specialty, health_insurance FROM appointments WHERE patient_name = ? AND phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $patientName, $patientPhone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the patient data
        $patient = $result->fetch_assoc();
        // Encode the patient data as JSON and send it as a response
        echo json_encode($patient);
    } else {
        // Patient not found
        echo json_encode(null);
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
