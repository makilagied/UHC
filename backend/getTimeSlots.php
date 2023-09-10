<?php
// Include your database connection code here
require_once('db.php');

// Check if the request is a GET request
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Get the selected doctor's specialty and date from the GET parameters
    $selectedSpecialty = $_GET["specialty"];
    $selectedDate = $_GET["date"];

    // Query the 'doctors' table to fetch the doctor's ID based on specialty
    $doctorQuery = "SELECT id FROM doctors WHERE specialty = '$selectedSpecialty'";
    $doctorResult = $conn->query($doctorQuery);

    if ($doctorResult && $doctorResult->num_rows > 0) {
        $doctorRow = $doctorResult->fetch_assoc();
        $selectedDoctorID = $doctorRow['id'];
        // Query the 'time_slots' table to fetch available time slots
        $sql = "SELECT start_time, end_time FROM time_slots WHERE date = '$selectedDate' AND doctor_id = '$selectedDoctorID' AND is_available = 1";
        $result = $conn->query($sql);

        if ($result === FALSE) {
            // Handle SQL query error
            echo json_encode(array("error" => $conn->error));
        } elseif ($result->num_rows > 0) {
            $timeSlots = array();

            // Fetch the available time slots and store them in an array
            while ($row = $result->fetch_assoc()) {
                $timeSlots[] = $row['start_time'] . " - " . $row['end_time'];
            }

            // Return the time slots as JSON
            echo json_encode(array("timeSlots" => $timeSlots));
        } else {
            // Return a message if there are no available time slots
            echo json_encode(array("message" => "No available time slots for the selected date and doctor specialty."));
        }
    } else {
        // Return a message if the doctor specialty is not found
        echo json_encode(array("message" => "Doctor with the selected specialty not found."));
    }

    // Close the database connection
    $conn->close();
}
?>
