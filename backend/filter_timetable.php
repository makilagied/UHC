<?php
// Include your database connection code here (backend/db.php)
require_once('db.php');

$filterDoctor = $_GET['filterDoctor'];
$filterDate = $_GET['filterDate'];

// Construct the SQL query based on the filter options
$sql = "SELECT doctors.name AS doctor_name, time_slots.date, time_slots.start_time, time_slots.end_time
        FROM time_slots
        INNER JOIN doctors ON time_slots.doctor_id = doctors.id
        WHERE (DATE(time_slots.date) = ? OR ? = '') AND (time_slots.doctor_id = ? OR ? = '')
        ORDER BY time_slots.date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $filterDate, $filterDate, $filterDoctor, $filterDoctor);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo '<table class="table table-bordered">';
    echo '<thead>';
    echo '<tr>';
    echo '<th>Doctor</th>';
    echo '<th>Day</th>';
    echo '<th>Start Time</th>';
    echo '<th>End Time</th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['doctor_name'] . '</td>';
        echo '<td>' . $row['date'] . '</td>';
        echo '<td>' . $row['start_time'] . '</td>';
        echo '<td>' . $row['end_time'] . '</td>';
        echo '</tr>';
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<p>No timetable available for the selected filters.</p>';
}
?>
