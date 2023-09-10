<?php
$servername = "localhost";
$username = "makilagied";
$password = "password";

// Create a connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the database
$dbname = "UHC";
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully<br>";
} else {
    echo "Error creating database: " . $conn->error;
}

// Select the created database
$conn->select_db($dbname);

// Create doctors table
$sql = "CREATE TABLE IF NOT EXISTS doctors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    specialty VARCHAR(255) NOT NULL,
    UNIQUE KEY unique_name (name)
)";
if ($conn->query($sql) === TRUE) {
    echo "Doctors table created successfully<br>";
} else {
    echo "Error creating doctors table: " . $conn->error;
}

// Create doctors table
$sql = "CREATE TABLE IF NOT EXISTS time_slots (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT,
    start_time TIME,
    end_time TIME,
    date DATE,
    is_available TINYINT DEFAULT 1, -- 1 for available, 0 for not available
    FOREIGN KEY (doctor_id) REFERENCES doctors(id)
)";
if ($conn->query($sql) === TRUE) {
    echo "Time slots table created successfully<br>";
} else {
    echo "Error creating time slots table: " . $conn->error;
}


// Create login table
$sql = "CREATE TABLE IF NOT EXISTS login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_id INT NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
)";
if ($conn->query($sql) === TRUE) {
    echo "Login table created successfully<br>";
} else {
    echo "Error creating login table: " . $conn->error;
}

// Create appointments table
$sql = "CREATE TABLE IF NOT EXISTS appointments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    doctor_specialty VARCHAR(255) NOT NULL,
    patient_name VARCHAR(255) NOT NULL,
    phone VARCHAR(15) NOT NULL,
    location VARCHAR(255) NOT NULL,
    health_insurance VARCHAR(255) NOT NULL,
    health_status_description TEXT,
    appointment_date DATE NOT NULL,
    selected_time_slot VARCHAR(8) NOT NULL,  -- Add a column for selected time slot
    approved INT DEFAULT 0
)";

if ($conn->query($sql) === TRUE) {
    echo "Appointments table created successfully<br>";
} else {
    echo "Error creating appointments table: " . $conn->error;
}


// Populate doctors table with initial data and login info
$doctorData = array(
    array('Dr. Juma', 'General checkup'),
    array('Dr. Anna ', 'Pediatrics'),
    array('Dr. Lilian', 'Dermatology'),
    array('Dr. Henry', 'Dental'),
    array('Dr. Johnson', 'Cardiology'),
    array('Dr. Amina', 'Physician'),
    array('Dr. Sam', 'Neurosurgery'),
    // Add more doctors here
);

foreach ($doctorData as $data) {
    $name = $data[0];
    $specialty = $data[1];

    $sql = "INSERT IGNORE INTO doctors (name, specialty) VALUES ('$name', '$specialty')";
    if ($conn->query($sql) === TRUE) {
        echo "Doctor '$name' added<br>";

        $doctorId = $conn->insert_id;
        $username = strtolower(str_replace(' ', '', $name));
        $password = 'UHC';

        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO login (doctor_id, username, password) VALUES ($doctorId, '$username', '$hashedPassword')";
        if ($conn->query($sql) === TRUE) {
            echo "Login info for '$name' added<br>";
        } else {
            echo "Error adding login info for '$name': " . $conn->error;
        }
    } else {
        echo "Error adding doctor '$name': " . $conn->error;
    }
}


$conn->close();
?>
