<?php
// Make sure to replace these values with your actual database credentials
$servername = "localhost";
$username = "your_username";
$password = "Bee19Knee's99";
$dbname = "appointment";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = $_POST["Full_Name"];
    $phone_number = $_POST["Phone_number"];
    $email = $_POST["email"];
    $location = $_POST["Your_location"];
    $time = $_POST["time"];
    $department = $_POST["Department"];
    $doctors = $_POST["Doctors"];
    $description = $_POST["Description"];

    $sql = "INSERT INTO appointments (full_name, phone_number, email, location, appointment_time, department, doctors, description)
            VALUES ('$full_name', '$phone_number', '$email', '$location', '$time', '$department', '$doctors', '$description')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment booked successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>