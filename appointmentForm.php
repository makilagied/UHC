<?php
// Database connection settings
$servername = "localhost";
$username = "root";
$password = "Bee19Knee's99";
$dbname = "UHC"; // Replace with your database name

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["patient_name"];
    $phone_number = $_POST["phone"];
    $location = $_POST["location"];
    $health_insurance = $_POST["health_insurance"];
    $health_status_description = $_POST["health_status_description"];
    $appointment_date = $_POST["appointment_date"];
    $department = $_POST["doctor_specialty"];

    $sql = "INSERT INTO appointments (doctor_specialty, patient_name, phone, location, health_insurance, health_status_description, appointment_date)
            VALUES ( '$department', '$full_name', '$phone_number', '$location', '$health_insurance', '$health_status_description', '$appointment_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
