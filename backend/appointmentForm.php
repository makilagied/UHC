<?php
require_once('db.php'); // Include the database connection file

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["patient_name"];
    $phone_number = $_POST["phone"];
    $location = $_POST["location"];
    $health_insurance = $_POST["health_insurance"];
    $health_status_description = $_POST["health_status_description"];
   
    $appointment_date = $_POST["appointment_date"];
    $department = $_POST["doctor_specialty"];

    $sql = "INSERT INTO appointments (doctor_specialty, patient_name, phone, location, health_insurance, health_status_description, appointment_date)
            VALUES ('$department', '$full_name', '$phone_number', '$location', '$health_insurance', '$health_status_description', '$appointment_date')";

    if ($conn->query($sql) === TRUE) {
        // Redirect to myappointment.php on success
        header("Location: ../myappointment.php");
        exit(); // Make sure to exit to prevent further script execution
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
