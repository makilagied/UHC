<?php
// Include your database connection code here
require_once('db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = $_POST["name"];
    $phoneNumber = $_POST["phoneNumber"];

    // Perform a database query to fetch appointment data based on name and phone number
    $sql = "SELECT * FROM appointments WHERE patient_name = ? AND phone = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $phoneNumber);
    $stmt->execute();
    $result = $stmt->get_result();

    $appointments = [];
    while ($row = $result->fetch_assoc()) {
        // Get the appointment status (approved or not)
        $status = $row["approved"] == 1 ? "Approved" : "Not Approved";

        // Add the status to the appointment data
        $row["status"] = $status;
        $appointments[] = $row;
    }

    // Encode the appointment data as JSON and send it as a response
    echo json_encode($appointments);

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
