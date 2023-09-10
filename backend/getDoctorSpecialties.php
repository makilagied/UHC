<?php
// Include your database connection code here
require_once('db.php');

// Query the 'doctors' table to fetch distinct doctor specialties
$sql = "SELECT DISTINCT specialty FROM doctors";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $specialties = array();

    // Fetch doctor specialties and store them in an array
    while ($row = $result->fetch_assoc()) {
        $specialties[] = $row['specialty'];
    }

    // Return the specialties as JSON
    echo json_encode(array("specialties" => $specialties));
} else {
    // Return an empty array if there are no specialties
    echo json_encode(array("specialties" => array()));
}

// Close the database connection
$conn->close();
?>
