<?php
// Include your database connection code here (backend/db.php)
require_once('db.php');

// Fetch the entire doctor's timetable from the 'time_slots' table
$sql = "SELECT doctors.name AS doctor_name, time_slots.day, time_slots.start_time, time_slots.end_time
        FROM time_slots
        INNER JOIN doctors ON time_slots.doctor_id = doctors.id
        ORDER BY time_slots.day DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['doctor_name'] . '</td>';
        echo '<td>' . $row['day'] . '</td>';
        echo '<td>' . $row['start_time'] . '</td>';
        echo '<td>' . $row['end_time'] . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr><td colspan="4">No timetable available.</td></tr>';
}
?>
